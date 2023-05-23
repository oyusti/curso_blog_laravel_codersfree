<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\Facades\Image;

class Resizeimage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $image_url;

    public function __construct($image_url)
    {
        $this->image_url = $image_url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $img=Image::make("storage/".$this->image_url);//creamos la imagen con la ruta de la imagen
            $img->resize(1200, null, function($constraint){//redimensionamos la imagen
                $constraint->aspectRatio();//mantenemos la proporcion
                $constraint->upsize();//si la imagen es mas pequeña no la agranda
            });
            $img->save('storage/'.$this->image_url, null, 'jpg');//guardamos la imagen
    }
}
