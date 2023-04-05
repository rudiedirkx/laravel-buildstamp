<?php

namespace rdx\buildstamp;

use Illuminate\Console\Command;

class BuildstampCommand extends Command {

	const CONFIG_NAME = 'APP_BUILDSTAMP';

	protected $signature = 'buildstamp';

	protected $description = 'Set the application build timestamp';

	public function handle() : int {
		$timestamp = time();

		$this->setBuildStampInEnvironmentFile($timestamp);

		$this->laravel['config']->set('icares.build_stamp', $timestamp);

		$this->info("Application buildstamp [$timestamp] set.");

		return 0;
	}

	protected function setBuildStampInEnvironmentFile(int $timestamp) : void {
		$filepath = $this->laravel->environmentFilePath();
		$content = file_get_contents($filepath);

		$lineNew = sprintf('%s=%s', self::CONFIG_NAME, $timestamp);

		// Replace the old timestamp with the new one.
		if ($stampOld = env(self::CONFIG_NAME)) {
			$content = str_replace(sprintf('%s=%s', self::CONFIG_NAME, $stampOld), $lineNew, $content);
		}
		else {
			$content .= "\n$lineNew\n";
		}

		$filepathNew = $filepath . '.new';
		$filepathOld = $filepath . '.old';
		if (file_put_contents($filepathNew, $content)) {
			if (file_exists($filepathOld)) {
				unlink($filepathOld);
			}

			rename($filepath, $filepathOld);
			rename($filepathNew, $filepath);
		}
	}

}
