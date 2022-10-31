<?php

namespace Tests\Feature\App\Controller\Admin\Course;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CourseControllerTest extends TestCase
{
    private $user;

    public function setUp(): void{
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder']);
        $this->user = Sentinel::findUserById(1);
        Sentinel::login($this->user, true);
    }
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index()
    {
        $response = $this->get(route('course.index'));
        $response->assertStatus(200);

        $response->assertSee('<h3 class="box-title">Course</h3>', false);
    }

    public function test_create(){
        $response = $this->get(route('course.create'));

        $response->assertStatus(200);
        $response->assertSee('<div class="card-header with-border">
        <h3 class="card-title">Course</h3>
    </div>', false);
    }

    /**
    * @test
    * @dataProvider set_course_data_test_is_invalid
    */

    public function test_store_is_invalid($invalidData, $invaludFields){
        $this->post(route('course.store'),$invalidData)
                        ->assertSessionHasErrors($invaludFields)
                        ->assertStatus(302);
    }

    public function set_course_data_test_is_invalid(){
        return [
            [
                [
                    'name' =>           '',
                    'description' =>    '',
                    'start_at' =>       '',
                    'finish_at' =>          '',
                ],
                [
                    'name',
                    'description',
                    'start_at',
                    'finish_at',
                ]
            ],
            [
                [
                    'name' =>           'Test',
                    'description' =>    '',
                    'start_at' =>       '',
                    'finish_at' =>          '',
                ],
                [
                    'description',
                    'start_at',
                    'finish_at',
                ]
            ],
            [
                [
                    'name' =>           'Test',
                    'description' =>    'Moi nguoi thu test thoi nhe',
                    'start_at' =>       '',
                    'finish_at' =>          '',
                ],
                [
                    'start_at',
                    'finish_at',
                ]
            ],
            [
                [
                    'name' =>           'Test',
                    'description' =>    'Moi nguoi thu test thoi nhe',
                    'start_at' =>       '28/12/2022',
                    'finish_at' =>          '',
                ],
                [
                    'start_at',
                    'finish_at',
                ]
            ],
        ];
    }

    public function test_store_success()
    {
        $productData = [
            'name' =>           'Test create course',
            'description' =>    'Test create course, Test create course, Test create course',
            'start_at' =>       '2022-09-08',
            'finish_at' =>          '2022-09-08',
        ];

        $response = $this->post(route('course.store'), $productData);

        $response->assertStatus(302);
        $response->assertRedirect(route('course.detail', ['id'=>11]));

        $this->assertDatabaseHas('course_translations', [
            'name' =>           'Test create course',
            'description' =>    'Test create course, Test create course, Test create course',
        ]);

        $this->assertDatabaseHas('courses', [
            'start_at' =>       '2022-09-08',
            'finish_at' =>          '2022-09-08',
        ]);

    }
}
