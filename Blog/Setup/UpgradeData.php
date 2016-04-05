<?php

namespace Windigo\Blog\Setup;

use Magento\Framework\Setup\UpgradeDataInterface,
	Magento\Framework\Setup\ModuleDataSetupInterface,
	Magento\Framework\Setup\ModuleContextInterface
		;

/**
 * Setup UpgradeData
 *
 * @author KuBik
 */
class UpgradeData implements UpgradeDataInterface {

	public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context) {
		$setup->startSetup();

		if (version_compare($context->getVersion(), '1.0.0') < 0) {
			// Get blog table
			$tableName = $setup->getTable('blog');
			// Check if the table already exists
			if ($setup->getConnection()->isTableExists($tableName) == true) {
				// Declare data
				$data = [
					[
						'title' => 'How to create a simple module',
						'identifier' => 'the_summary',
						'creation_time' => date('Y-m-d H:i:s'),
						'is_active' => 1
					],
					[
						'title' => 'Create a module with custom database table',
						'identifier' => 'the_summary_2',
						'creation_time' => date('Y-m-d H:i:s'),
						'is_active' => 1
					]
				];

				// Insert data to table
				foreach ($data as $item) {
					$setup->getConnection()->insert($tableName, $item);
				}
			}
		}

		$setup->endSetup();
	}

}
