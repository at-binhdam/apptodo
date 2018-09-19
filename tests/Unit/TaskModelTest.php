<?php

/**
 * This file is part of the test
 * Handle test model task
 *
 * @author  Binhdq <binhdq92@gmail.com>
 * @license https://github.com/at-binhdam/apptodo App Todo
 */
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\TaskModel;
use Faker\Factory as Faker;

class TaskModelTest extends TestCase
{
    public $taskModel;

    /**
     * Function setup for run test
     *
     * @return void
     */
    public function setUp()
    {
        $this->taskModel = new TaskModel();
    }

    /**
     * Provider data to test function insert task
     *
     * @return array
     */
    public function providerTestInsertTaskSuccess()
    {
        $totalDataTest = 5;
        $dataTest = [];

        $faker = Faker::create();
        
        for ($i = 0; $i < $totalDataTest; $i++) {
            $dataTest[] = [
                [
                    'name' => $faker->name,
                    'start_date' => $faker->date('Y-m-d', 'now'),
                    'end_date' => $faker->date('Y-m-d', 'now'),
                    'status' => $faker->numberBetween(0, 2)
                ]
            ];
        }
        
        return $dataTest;
    }
    
    /**
     * Test function insert task is success and return id of task
     *
     * @param array $infoTask Data of task
     *
     * @dataProvider providerTestInsertTaskSuccess
     *
     * @return void
     */
    public function testInsertTaskSuccessReturnIdTask($infoTask)
    {
        $idTask = $this->taskModel->insertTask($infoTask);
        
        $this->assertGreaterThan(0, $idTask);
    }

    /**
     * Test function update task is success and return true
     *
     * @param array $infoTask Data of task
     *
     * @dataProvider providerTestInsertTaskSuccess
     *
     * @return void
     */
    public function testInsertTaskSuccessReturnTrue($infoTask)
    {
        $idTask = $this->taskModel->insertTask($infoTask);
        
        $faker = Faker::create();

        $infoTaskUpdate = [
            'name' => $faker->name,
            'status' => $faker->numberBetween(0, 2)
        ];

        $resultUpdate = $this->taskModel->updateTaskById($idTask, $infoTask);

        $this->assertEquals(true, $resultUpdate);
    }

    /**
     * Test function delete task is success and return true
     *
     * @param array $infoTask Data of task
     *
     * @dataProvider providerTestInsertTaskSuccess
     *
     * @return void
     */
    public function testDeleteTaskSuccessReturnTrue($infoTask)
    {
        $idTask = $this->taskModel->insertTask($infoTask);
        
        $resultDelete = $this->taskModel->deleteTaskById($idTask);

        $this->assertEquals(true, $resultDelete);
    }

    /**
     * Test function find task by id is success and return info of task
     *
     * @param array $infoTask Data of task
     *
     * @dataProvider providerTestInsertTaskSuccess
     *
     * @return void
     */
    public function testFindTaskByIdSuccessReturnArray($infoTask)
    {
        $idTask = $this->taskModel->insertTask($infoTask);
        
        $infoTask = $this->taskModel->findTaskById($idTask);
        
        $this->assertNotEmpty($infoTask);
    }

    /**
     * Test function find all task is success and return array
     *
     * @param array $infoTask Data of task
     *
     * @dataProvider providerTestInsertTaskSuccess
     *
     * @return void
     */
    public function testFindAllTaskSuccessReturnArray($infoTask)
    {
        $this->taskModel->insertTask($infoTask);
        
        $listTasks = $this->taskModel->findAllTask();
        
        $this->assertNotEmpty($listTasks);
    }

    /**
     * Test function delete all task is success and return true
     *
     * @param array $infoTask Data of task
     *
     * @dataProvider providerTestInsertTaskSuccess
     *
     * @return void
     */
    public function testDeleteAllTaskSuccessReturnTrue($infoTask)
    {
        $this->taskModel->insertTask($infoTask);

        $resultDelete = $this->taskModel->deleteAllTask();
        
        $this->assertEquals(true, $resultDelete);
    }
}
