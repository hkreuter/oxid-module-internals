<?php
/**
 * Module internals tools data helper tests.
 *
 * @author Alfonsas Cirtautas
 */
class ac_module_internals_data_helperTest extends PHPUnit_Framework_TestCase {

    public function testGetModule()
    {
        $oModule     = $this->getMock('oxmodule');
        $oModuleList = $this->getMock('oxmodulelist');

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);

        $this->assertEquals($helper->getModule(), $oModule);
    }

    public function testSetModule()
    {
        $oModule = $this->getMock('oxmodule', array('isCustom'));
        $oModule->method('isCustom')->willReturn(false);

        $oCustomModule = $this->getMock('oxmodule', array('isCustom'));
        $oCustomModule->method('isCustom')->willReturn(true);

        $oModuleList = $this->getMock('oxmodulelist');

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);

        $helper->setModule($oCustomModule);

        $this->assertTrue($helper->getModule()->isCustom());
    }

    public function testGetModuleList()
    {
        $oModule     = $this->getMock('oxmodule');
        $oModuleList = $this->getMock('oxmodulelist');

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);

        $this->assertEquals($helper->getModuleList(), $oModuleList);
    }

    public function testSetModuleList()
    {
        $oModule = $this->getMock('oxmodule');

        $oModuleList = $this->getMock('oxmodulelist', array('isCustom'));
        $oModuleList->method('isCustom')->willReturn(false);

        $oCustomModuleList = $this->getMock('oxmodulelist', array('isCustom'));
        $oCustomModuleList->method('isCustom')->willReturn(true);

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);

        $helper->setModuleList($oCustomModuleList);

        $this->assertTrue($helper->getModuleList()->isCustom());
    }

    public function testSetGetConfig()
    {
        $oModule     = $this->getMock('oxmodule');
        $oModuleList = $this->getMock('oxmodulelist');

        $oConfig = $this->getMock('oxconfig');

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);

        $helper->setConfig($oConfig);

        $this->assertEquals($helper->getConfig(), $oConfig);
    }

    public function testSetGetDb()
    {
        $oModule     = $this->getMock('oxmodule');
        $oModuleList = $this->getMock('oxmodulelist');

        $oDb = $this->getMock('oxLegacyDb');

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);

        $helper->setDb($oDb);

        $this->assertEquals($helper->getDb(), $oDb);
    }

    public function testGetInfo()
    {
        $oModule = $this->getMock('oxmodule', array('getInfo'));
        $oModule->method('getInfo')->willReturn('info');

        $oModuleList = $this->getMock('oxmodulelist');

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);

        $this->assertEquals($helper->getInfo('id'), 'info');
    }

    public function testGetModuleBlocks()
    {
        $oModule = $this->getMock('oxmodule', array('getId'));
        $oModule->method('getId')->willReturn('module-id');

        $oModuleList = $this->getMock('oxmodulelist');

        $oConfig = $this->getMock('oxConfig', array('getShopId'));
        $oConfig->method('getShopId')->willReturn('shop-id');

        $oDb = $this->getMock('oxLegacyDb', array('getAll'));
        $oDb->expects($this->any())
            ->method('getAll')
            ->with($this->anything(), $this->equalTo( array('module-id','shop-id')))
            ->willReturn('module-themes');

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);
        $helper->setConfig($oConfig);
        $helper->setDb($oDb);

        $this->assertEquals($helper->getModuleBlocks(), 'module-themes');
    }

    public function testGetModuleSettings()
    {
        $oModule = $this->getMock('oxmodule', array('getId'));
        $oModule->method('getId')->willReturn('module-id');

        $oModuleList = $this->getMock('oxmodulelist');

        $oConfig = $this->getMock('oxConfig', array('getShopId'));
        $oConfig->method('getShopId')->willReturn('shop-id');

        $oDb = $this->getMock('oxLegacyDb', array('getAll'));
        $oDb->expects($this->any())
            ->method('getAll')
            ->with($this->anything(), $this->equalTo( array('module-id','shop-id')))
            ->willReturn('module-settings');

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);
        $helper->setConfig($oConfig);
        $helper->setDb($oDb);

        $this->assertEquals($helper->getModuleBlocks(), 'module-settings');
    }

    public function testGetModuleFiles()
    {
        $aAllModuleFiles = array(
            'module-id'         => array( 'file1', 'file2'),
            'another-module-id' => array( 'file3', 'file4'),
        );

        $oModule = $this->getMock('oxmodule', array('getId'));
        $oModule->method('getId')->willReturn('module-id');

        $oModuleList = $this->getMock('oxmodulelist', array('getModuleFiles'));
        $oModuleList->method('getModuleFiles')->willReturn($aAllModuleFiles);

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);

        $this->assertEquals($helper->getModuleFiles(), $aAllModuleFiles['module-id']);
    }

    public function testGetModuleTemplates()
    {
        $aAllModuleTemplates = array(
            'module-id'         => array( 'template1', 'template2'),
            'another-module-id' => array( 'template3', 'template4'),
        );

        $oModule = $this->getMock('oxmodule', array('getId'));
        $oModule->method('getId')->willReturn('module-id');

        $oModuleList = $this->getMock('oxmodulelist', array('getModuleTemplates'));
        $oModuleList->method('getModuleTemplates')->willReturn($aAllModuleTemplates);

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);

        $this->assertEquals($helper->getModuleTemplates(), $aAllModuleTemplates['module-id']);
    }

    public function testGetModuleEvents()
    {
        $aAllModuleEvents = array(
            'module-id'         => array( 'event1', 'event2'),
            'another-module-id' => array( 'event3', 'event4'),
        );

        $oModule = $this->getMock('oxmodule', array('getId'));
        $oModule->method('getId')->willReturn('module-id');

        $oModuleList = $this->getMock('oxmodulelist', array('getModuleEvents'));
        $oModuleList->method('getModuleEvents')->willReturn($aAllModuleEvents);

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);

        $this->assertEquals($helper->getModuleEvents(), $aAllModuleEvents['module-id']);
    }

    public function testGetModuleVersion()
    {
        $aAllModuleVersions = array(
            'module-id'         => 'version1',
            'another-module-id' => 'version2',
        );

        $oModule = $this->getMock('oxmodule', array('getId'));
        $oModule->method('getId')->willReturn('module-id');

        $oModuleList = $this->getMock('oxmodulelist', array('getModuleVersions'));
        $oModuleList->method('getModuleVersions')->willReturn($aAllModuleVersions);

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);

        $this->assertEquals($helper->getModuleVersion(), $aAllModuleVersions['module-id']);
    }
}
