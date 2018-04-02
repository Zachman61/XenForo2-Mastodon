<?php

namespace Z61\Mastodon;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	public function installStep1()
    {
        $this->db()->insert('xf_connected_account_provider', [
            'provider_id' =>  'z61Mastodon',
            'provider_class' => 'Z61\Mastodon:Provider\Mastodon',
            'display_order' => 10,
            'options' => ''
        ]);
    }
}