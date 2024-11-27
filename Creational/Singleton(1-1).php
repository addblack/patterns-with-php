<?php

class Logger
{
    // ? - nullable type, Logger can be Logger or null
    private static ?Logger $instance = null;
    private int $messageCount = 0;
    private string $logFile;

    public const INFO = 'Information';
    public const WARNING = 'Warning';
    public const ERROR = 'Error';

    // Private constructor to prevent creating a lot of Logger classes
    private function __construct(string $logFile)
    {
        $this->logFile = $logFile;
    }

    // To get only one instanse of Logger calss
    public static function getInstance(string $logFile): Logger
    {
        if (self::$instance === null) {
            self::$instance = new self($logFile);
        }
        return self::$instance;
    }

    public function log(string $message, string $type = self::INFO): void
    {
        $this->messageCount++;
        $dateTime = new DateTime();
        $logMessage = sprintf(
            "[%s] Повідомлення #%d: %s | Тип: %s\n",
            $dateTime->format('Y-m-d H:i:s'),
            $this->messageCount,
            $message,
            $type
        );
        
        file_put_contents($this->logFile, $logMessage, FILE_APPEND);
    }
}

// Example of using
$logger = Logger::getInstance('logfile.txt');
$logger->log('Це інформаційне повідомлення.');
$logger->log('Це попередження.', Logger::WARNING);
$logger->log('Це помилка.', Logger::ERROR);
