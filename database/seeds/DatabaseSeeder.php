<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $tableNames = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();
        foreach ($tableNames as $name) {
            //if you don't want to truncate migrations
            /*if ($name == 'migrations') {
                continue;
            }*/
            DB::table($name)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        factory('App\User',20)->create();
        factory('App\Classexam',10)->create();
            /*->each(function($u){
            //$u->classindividual()->save(factory('App\Classindividual',1)->create());
        });*/
        factory('App\Exam',10)->create();
        factory('App\Classindividual',200)->create()->each(function($u){
            App\Classexam::all()->random()->member()->save($u);
            if($u->accessibility == 1){
                //App\Exam::all()->random()->instructor()->save($u);
            }
        });

        $classes = App\Classexam::all();
        foreach($classes as $class){
            App\Classindividual::all()->where('accessibility',1)->random()->ins()->save($class);
            $class->exam()->save(App\Exam::all()->random());
            //App\Classindividual::all()->where('accessibility',1)->random()->insexam()->save($class);
            //$class->instructor()->save(App\Classindividual::all()->where('accessibility',1)->random());
        }


        factory('App\Basket',500)->create()->each(function($u){
            $exam = App\Exam::all()->random();
            $exam->basket()->save($u);
            App\Classindividual::all()->random()->Qbasket()->save($u);
            App\Classindividual::all()->random()->Rbasket()->save($u);
            //$u->exam()->save(App\Exam::all()->random());
            //$u->responder()->save(App\Classindividual::all()->where('examID',$u->examID)->random());
            //$u->questioner()->save(App\Classindividual::all()->where('examID',$u->examID)->random());
        });

        factory('App\Studentinfo',200)->create()->each(function($u){
            //$u->participants()->save(App\Classindividual::all()->random());
            App\Classindividual::all()->random()->person()->save($u);
            $individual = $u->individuals();
            //$u->exam()->save(App\Exam::all()->random());
            App\Exam::all()->random()->student()->save($u);
            if($individual->accessibility == 1){
                //$u->exam()->save(App\Exam::where('examID',$individual->insexam()->examID));
            }
            else{
                //$u->exam()->save(App\Exam::all()->random());
            }
        });
    }
}
