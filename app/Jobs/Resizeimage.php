<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
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
        //Codigo para redimensionar la imagen con uso de las colas
        $image=Storage::get($this->image_url);
        $img = Image::make($image); //creamos la imagen con la ruta de la imagen
        $img->resize(1200, null, function ($constraint) { //redimensionamos la imagen
            $constraint->aspectRatio(); //mantenemos la proporcion
            $constraint->upsize(); //si la imagen es mas pequeña no la agranda
        });

        $img->stream('jpg'); 

        Storage::put($this->image_url, $img); //guardamos la imagen
        
        //Codigo para redimensionar la imagen sin uso de las colas
        /* $img = Image::make("storage/" . $this->image_url); //creamos la imagen con la ruta de la imagen
        $img->resize(1200, null, function ($constraint) { //redimensionamos la imagen
            $constraint->aspectRatio(); //mantenemos la proporcion
            $constraint->upsize(); //si la imagen es mas pequeña no la agranda
        });
        $img->save('storage/' . $this->image_url, null, 'jpg'); //guardamos la imagen */
    }
}
