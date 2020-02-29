<?php
class Container
{
    private $configuration;
    private $pdo;
    private $CityLoader;
    private $MessageService;
    private $TemplateLoader;
    private $UserService;
    private $CityPusher;
    private $MenuLoader;


    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @return PDO
     */
    public function getPDO()
    {
        if ($this->pdo === null) {
            $this->pdo = new PDO(
                $this->configuration['dbdsn'],
                $this->configuration['dbuser'],
                $this->configuration['dbpassword']
            );

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $this->pdo;
    }
    public function getCityLoader()
    {
        if ($this->CityLoader === null) {
            $this->CityLoader = new CityLoader($this->getPDO());
        }

        return $this->CityLoader;
    }
    public function getMessageService()
    {
        if ($this->MessageService === null) {
            $this->MessageService = new messageService();
        }

        return $this->MessageService;
    }
    public function getTemplateLoader()
    {
        if ($this->TemplateLoader === null) {
            $this->TemplateLoader = new messageService();
        }

        return $this->TemplateLoader;
    }
    public function getUserService()
    {
        if ($this->UserService === null) {
            $this->UserService = new messageService();
        }

        return $this->UserService;
    }

    public function getCityPusher()
    {
        if ($this->CityPusher === null) {
            $this->CityPusher = new cityPusher();
        }

        return $this->CityPusher;
    }

    public function getMenuLoader()
    {
        if ($this->MenuLoader === null) {
            $this->MenuLoader = new menuLoader();
        }

        return $this->MenuLoader;
    }
}
