<?php

namespace rdx\buildstamp;

use Illuminate\Support\ServiceProvider;

class BuildstampServiceProvider extends ServiceProvider {

	public function boot() : void {
		$this->commands([
			BuildstampCommand::class,
		]);
	}

}
