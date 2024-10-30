<?php
/**
 * \file ErrorLogging.php
 * \brief Implements an error logger.
 *
 * Creates a log file upon loging attempt.
 * File name can be changed by changing <plugin-prefix>_LOG_FILE_NAME definition
 */

/**
 * TODO: Take care of big log files (check file size limit before every log alteration)
 * TODO: Check if log file has been opened up on instanciation. What to do if - not?
 * TODO: Add verbosity control
 * TODO: Add calling function name alog with a timpstamp in the log
 * TODO: Allow to set prefix that will include application name (lets to recognize the source of the log file)
 * TODO: Pack logging code in namespace, to avoid changing the code for each new plugin
 */

/* Make sure we don't expose any info if called directly */
if ( !function_exists( 'add_action' ) ) {
	die("This application is not meant to be called directly!");
}


define( "bghea_plugin__LOG_FILE_NAME", plugin_dir_path(__FILE__) . "/bghea_log_file.log");


class bghea_LogFile {
	public function Error( $message) {
		fwrite( $this->_logFileHandle,
			$this->getTimeStamp() . " " ."ERROR: " . $message . "\n"
		);
	}

	public function Warning( $message) {
		fwrite( $this->_logFileHandle,
			$this->getTimeStamp() . " " . "WARNING: " . $message . "\n"
		);
	}

	public function Info( $message) {
		fwrite( $this->_logFileHandle, 
			$this->getTimeStamp(). " " . "INFO: " . $message . "\n"
		);
	}

	 public static function getInstance() {
		if( null == self::$_errorLogInstance) {
			self::$_errorLogInstance = new bghea_LogFile();
			self::$_errorLogInstance->_logFileHandle = 
				fopen( self::$_errorLogInstance->_logFileName, 'a');
		}

		return self::$_errorLogInstance;
	}

	private function __construct() {
	}

	public function __destruct() {
		if( $this->_logFileHandle != null) {
			fclose( $this->_logFileHandle);
		}
	}

	private function getTimeStamp() {
		return date( "h:i:s d.m.y");
	}
	
	private $_logTimeStamp = "";
	private $_logFileName = bghea_plugin__LOG_FILE_NAME;
	private $_logFileHandle = null;
	private static $_errorLogInstance = null;
};

?>