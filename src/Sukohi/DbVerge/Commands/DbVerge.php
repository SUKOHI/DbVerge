<?php namespace Sukohi\DbVerge\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DbVerge extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'db:verge';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Show first or last row data of DB.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$orderby = ($this->option('orderby') == 'asc') ? 'asc' : 'desc';
		$target_table = $this->option('table');
		$limit = $this->option('limit');
		$tables = \DB::select('SHOW TABLES');
		$table_prefix = \DB::getTablePrefix();
		$db_name = \DB::getDatabaseName();

		foreach ($tables as $table) {

			$table_property = 'Tables_in_'. $db_name;
			$table_in_laravel = $table->{$table_property};
			$table_name = preg_replace('|^'. $table_prefix .'|', '', $table_in_laravel);
			$column_names = $this->columnNames($table_in_laravel);

			if(!is_null($target_table) && $target_table !== $table_name) {

				continue;

			} else if(!in_array('id', $column_names)) {

				continue;

			}

			$db = \Db::table($table_name)
				->orderBy('id', $orderby)
				->take($limit);

			$rows = $db->get();

			if(count($rows) > 0) {

				$columns = \DB::select('SHOW COLUMNS FROM '. $table_in_laravel);
				$this->info('+ '. $table_name .' +++');

				foreach ($rows as $row) {

					$row_content = '';

					foreach ($columns as $column) {

						$column_name = $column->Field;
						$column_value = $row->$column_name;
						$row_content .= '['. $column_name .']: '. $column_value ."\n";

					}

					$this->info($row_content);

				}

			}

		}

	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('table', null, InputOption::VALUE_OPTIONAL, 'A specific table name.', null),
			array('limit', null, InputOption::VALUE_OPTIONAL, 'A specific table name.', 1),
			array('orderby', null, InputOption::VALUE_OPTIONAL, 'An order direction.(`asc` or `desc`)', 'desc'),
		);
	}

	private function columnNames($table_in_laravel) {

		$columns = \DB::select('SHOW COLUMNS FROM '. $table_in_laravel);
		$column_names = [];

		foreach ($columns as $column) {

			$column_names[] = $column->Field;

		}

		return $column_names;

	}

}
