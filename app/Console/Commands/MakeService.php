<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeService extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '創建 Service 檔案';



    protected $type = 'Services';



    /**
     * Get the stub file for the generated
     *
     * @return string
     */

    protected function getStub()
    {
        return __DIR__ . '/Stubs/services.stub';
    }

    /**
     * Get the stub file for the generator
     *
     * @param  string  $rootNamespace
     * @return string
     */

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Services';
    }
   
    /**
     * Get the destination class path.
     * 複寫(override) 父類別之函數,改成我想要的檔名
     *
     * @param  string  $name
     * @return string
     */

    //  protected function getPath($name)
    //  {
    //     $name = Str::replaceFirst($this->rootNamespace(), '', $name);

    //     return $this->laravel['path'].'/'.str_replace('\\','/', $name).'Service.php';

    //  }


    /**
     * Execute the console command.
     * 擴增額外功能
     * @return mixed
     */
    public function handle()
    {
        parent::handle();
    }
}
