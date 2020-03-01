<?php


class UploadService
{
    private $target_dir = "../img/";                                                          //de map waar de afbeelding uiteindelijk moet komen; relatief pad tov huidig script
    private $max_size = 5000000;                                                           //maximum grootte in bytes
    private $allowed_extensions = [ "jpeg", "jpg", "png", "gif" ];

    public function ProfielUpload()
    {
        $User = new User();
        if (isset($_POST["submit"]) == "Opladen") {
            //$target_dir = de map waar de afbeeldingen uiteindelijk moet komen
            $target_dir = "../img/"; //de map waar de afbeelding uiteindelijk moet komen; relatief pad tov huidig script
            $max_size = 5000000;     //maximum grootte in bytes

            $images = array();

            //pasfoto, eid_voorzijde en eid_achterzijde overlopen
            foreach ($_FILES as $inputname => $fileobject)   //overloop alle bestanden in $_FILES
            {
                $tmp_name = $fileobject["tmp_name"];
                $originele_naam = $fileobject["name"];
                $size = $fileobject["size"];
                $extensie = pathinfo($originele_naam, PATHINFO_EXTENSION);

                $target = "";

                //CONTROLES
                $max_size = 20000000; //maximum grootte in bytes
                $allowed_extensions = ["jpeg", "jpg", "png", "gif"]; //toegelaten bestandsextensies
                $cancel = false;

                //grootte
                if ($size > $max_size) {
                    print "Bestand " . $originele_naam . " is te groot (" . $size . " bytes). Maximum $max_size bytes!<br>";
                    $cancel = true;
                }

                //toegelaten extensies
                if (!in_array(pathinfo($originele_naam, PATHINFO_EXTENSION), $allowed_extensions)) {
                    print "Bestand " . $originele_naam . ": verkeerde bestandsextensie!<br>";
                    $cancel = true;
                }

                //is het bestand wel echt een afbeelding?
                if (getimagesize($tmp_name) === false) {
                    print "Bestand " . $originele_naam . " is niet echt een afbeelding!<br>";
                    $cancel = true;
                }

                if (!$cancel) {
                    switch ($inputname) {
                        case "pasfoto":
                            $target = "pasfoto_" . $User->getid() . "." . $extensie;
                            $images[] = "usr_pasfoto='" . $target . "'";
                            break;
                        case "eidvoor":
                            $target = "eidvoor_" . $_SESSION["usr"]["usr_id"] . "." . $extensie;
                            $images[] = "usr_vz_eid='" . $target . "'";
                            break;
                        case "eidachter":
                            $target = "eidachter_" . $_SESSION["usr"]["usr_id"] . "." . $extensie;
                            $images[] = "usr_az_eid='" . $target . "'";
                            break;
                    }

                    $target = $target_dir . $target;

                    //bestand verplaatsen naar definitieve locatie
                    print "Moving " . $inputname . " to " . $target . "<br>";

                    if (move_uploaded_file($tmp_name, $target)) {
                        print "Bestand $originele_naam opgeladen<br>";
                    } else print "Sorry, there was an unexpected error uploading file " . $originele_naam . "<br>";
                }
            }

            //de afbeeldingen opslaan in het gebruikersprofiel
            $sql = "update users SET " . implode(",", $images) . " where usr_id=" . $User->getId();
            ExecuteSQL($sql);

            //eventueel een redirect naar de profielpagina

        }
    }

    public function uploadFile(){
        if ( isset($_POST["submit"]) AND $_POST["submit"] == "Opladen" ) //als het juiste form gesubmit werd
        {
            //overloop alle bestanden in $_FILES
            foreach ( $_FILES as $f )
            {
                $upfile = array();
                $upfile["name"]                            = basename($f["name"]);
                $upfile["tmp_name"]                    = $f["tmp_name"];
                $upfile["target_path_name"]       = $this->target_dir . $upfile["name"]; //samenstellen definitieve bestandsnaam (+pad)    //basename
                $upfile["extension"]                      = pathinfo($upfile["name"], PATHINFO_EXTENSION);
                $upfile["getimagesize"]                = getimagesize($upfile["tmp_name"]);                 //getimagesize geeft false als het bestand geen afbeelding is
                $upfile["size"]                                = $f["size"];

                $result = $this->CheckUploadedFile( $upfile, $check_real_image = true, $check_if_exists = false, $check_max_size = true, $check_allowed_extensions = true );

                if ( !$result ) echo "Sorry, your file was not uploaded.<br>";
                else
                {
                    //bestand verplaatsen naar definitieve locatie + naam
                    if ( move_uploaded_file( $upfile["tmp_name"], $upfile["target_path_name"] ))
                    {
                        $new_url =  "/PHP_OOP/testremote_new/file_upload.php?Upload=true";
                        header("Location: $new_url");
                    }
                    else
                    {
                        echo "Sorry, there was an unexpected error uploading file " . $upfile["name"] . "<br>";
                    }
                }
            }
        }
    }

    private function CheckUploadedFile($upfile, $check_real_image = true, $check_if_exists = true, $check_max_size = true, $check_allowed_extensions = true ){
        global $allowed_extensions, $max_size;

        $returnvalue = true;

        // Check if image file is a actual image or fake image
        if ( $check_real_image AND $upfile["getimagesize"] === false )
        {
            echo "File " . $upfile["name"] . " is not an image.<br>"; $returnvalue = false;
        }

        // Check if file already exists
        if ( $check_if_exists AND file_exists($upfile["target_path_name"]))
        {
            echo "File  " . $upfile["name"] . " already exists.<br>"; $returnvalue = false;
        }

        // Check file size
        if ( $check_max_size AND $upfile["size"] > $this->max_size )
        {
            echo "File  " . $upfile["name"] . "  is too large.<br>"; $returnvalue = false;
        }

        // Allow only certain file formats
        if ( $check_allowed_extensions )
        {
            if ( ! in_array( $upfile["extension"], $this->allowed_extensions) )
            {
                echo "Wrong extension. Only " . implode(", ", $allowed_extensions) . " files are allowed.<br>";
                $returnvalue = false;
            }
        }
        return $returnvalue;
    }
}