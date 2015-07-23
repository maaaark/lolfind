<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	public function mail(){
		return View::make("emails.mail");
	}

	public function legal(){
		return View::make("page.legal");
	}

	public function tos(){
		return View::make("page.tos");
	}

}
