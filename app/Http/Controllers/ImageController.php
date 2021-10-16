<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\imageStoreRequest;
use Illuminate\Support\Facades\File; 
use App\Models\ImageModel;
use Image;

class ImageController extends Controller
{
    public function imageUpload(imageStoreRequest $request){
        //http://image.intervention.io/use/basics        
        
        $validated = $request->validated(); 
        //dd($validated);        
        $imot_id = $validated['imot_id'];        
        $dir = 'images/imoti/'.date("Y/m/");
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $image = $validated['photo'];
        $filename = substr($image->getFileName(), 3, -4);  //$avatar->getClientOriginalExtension()
        Image::make($image)->fit(120, 120)->encode('jpg', 70)->save( public_path($dir . $imot_id .'_'. $filename . '-120x120.jpg' ));
        Image::make($image)->insert('images/general/watermark.png', 'center')->fit(250, 180)->encode('jpg', 70)->save( public_path($dir . $imot_id .'_'. $filename . '-250x180.jpg' ));
        Image::make($image)->insert('images/general/watermark.png', 'center')->fit(480, 300)->encode('jpg', 70)->save( public_path($dir . $imot_id .'_'. $filename . '-480x300.jpg' ));
        Image::make($image)->insert('images/general/watermark.png', 'center')->fit(1000, 750)->encode('jpg', 80)->save( public_path($dir . $imot_id .'_'. $filename . '-1000x750.jpg' ));                
        $photo = new ImageModel;
        $photo->imot_id = $imot_id;
        $photo->path = $dir;
        $photo->filename = $filename;
        $photo->position = $validated['position'];
        $photo->save();
    
        $request->session()->flash('alert-success', 'Image uploaded');
        
        return redirect()->route('dashImot', ['id' => $imot_id]);
    }

    public function imageReposition(Request $request){
        $positions = array(); //dd($request);
        $data = $request->all();
        $data = json_decode($data['data'], true);
        foreach ($data as $value){            
            array_push($positions, $value['id']);
        }
        //dd($positions);
        foreach($positions as $key => $value){ 
            $position = ImageModel::find($value); 
            $position->position = $key+1; 
            $position->save(); 
        }
        $request->session()->flash('alert-success', 'Images position updated');
        return back();
    }

    public function imageDelete(Request $request, $id)
    {   
        $image = ImageModel::find($id);
        $image->delete();
        $file1 =  public_path($image->path . $image->imot_id .'_'. $image->filename . '-120x120.jpg' );  // Value is not URL but directory file path
        $file2 =  public_path($image->path . $image->imot_id .'_'. $image->filename . '-250x180.jpg' );  // Value is not URL but directory file path
        $file3 =  public_path($image->path . $image->imot_id .'_'. $image->filename . '-480x300.jpg' );  // Value is not URL but directory file path
        $file4 =  public_path($image->path . $image->imot_id .'_'. $image->filename . '-1000x750.jpg' );  // Value is not URL but directory file path
        //dd($image, $id, $image_path);
        if(File::exists($file1)) {
            File::delete($file1, $file2, $file3, $file4);

            $request->session()->flash('alert-success', 'Image deleted');
            return back();
        }
        $request->session()->flash('alert-error', 'Image deliting failed');
        return back();
    }

}
