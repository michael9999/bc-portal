<?php
class Livedocx_Admin {
	private static $initiated = false;

	public static function init() {
		if ( ! self::$initiated ) {
			self::init_hooks();
		}

		if ( isset( $_POST['action'] ) && $_POST['action'] == 'enter-key' ) {
			self::enter_api_key();
		}
	}

	public static function init_hooks() {
		self::$initiated = true;
		add_action( 'admin_menu', array( 'Livedocx_Admin', 'admin_menu' ), 5 );
	}

	public static function admin_menu() {
		if ( class_exists( 'Jetpack' ) )
			add_action( 'jetpack_admin_menu', array( 'Livedocx_Admin', 'load_menu' ) );
		else
			self::load_menu();
	}

	public static function admin_head() {
		if ( !current_user_can( 'manage_options' ) )
			return;
	}
	

	public static function load_menu() {
		if ( class_exists( 'Jetpack' ) )
			$hook = add_submenu_page( 'jetpack', __( 'Livedocx' , 'livedocx'), __( 'Livedocx' , 'livedocx'), 'manage_options', 'livedocx-key-config', array( 'Livedocx_Admin', 'display_page' ) );
		else
			$hook = add_options_page( __('Livedocx', 'livedocx'), __('Livedocx', 'livedocx'), 'manage_options', 'livedocx', array( 'Livedocx_Admin', 'display_page' ) );

	}

	public static function display_page() {
		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			echo self::display_tests_page();
		} else {
			$notWritablePaths = self::checkDirectories();
			echo Livedocx::view( 'dashboard', compact('notWritablePaths') );
		}
	}

	public static function display_tests_page() {
		$testResults = self::livedocx_tests();
		$filter = new \Zend\Filter\Word\SeparatorToSeparator('-', ' ');
		return Livedocx::view( 'tests' , compact( 'testResults', 'filter'));
	}

	public static function checkDirectories()
	{
		$errors = array();
		foreach (new \RecursiveIteratorIterator(self::getDemosIterator()) as $file) {
			/** @var SplFileInfo $file */
			if($file->isDir()) {
				if(!is_writable($file->getPath()) && $file->getPath() != self::getDemosPath()) {
					$errors[$file->getPath()] = $file->getPath();
				}
			}
		}
		return $errors;
	}

	public static function livedocx_tests()
	{
		$results = array();
		$premiumDemos = array(
			'subtemplates',
			'instantiation',
			'pdf-security'
		);

		$it = self::getDemosIterator();
		$demosPath = self::getDemosPath();
		foreach (new \RecursiveIteratorIterator($it) as $file) {
			/** @var SplFileInfo $file */
			$demoName = str_replace($demosPath.DIRECTORY_SEPARATOR,'',$file->getPath());
			$demoSubname = $file->getBasename('.php');

			if ('php' === substr($file->getFilename(), -3) && !in_array($demoName, $premiumDemos)) {
				$demoWPResult = array('demoName'=>$demoName, 'demoSubname'=>$demoSubname);
				ob_start();
				chdir($file->getPath());
				include_once $file->getPathname();
				$demoWPResult['body'] = ob_get_clean();
				$results[] = $demoWPResult;
			}
		}

		return $results;
	}

	public static function getDemosPath()
	{
		return realpath(LIVEDOCX__PLUGIN_DEMOS_DIR.'ZendService/LiveDocx/MailMerge');
	}

	public static function getDemosIterator()
	{
		$demosPath = self::getDemosPath();
		return new \RecursiveDirectoryIterator($demosPath);
	}

}