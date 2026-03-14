

                                            <h5 class="mb-3 border-bottom pb-2 d-flex justify-content-center">Bike Images</h5>
                                            <div class="row">
                                                @php
                                                    $documents = [
                                                        'bike_img_1' => 'Image 1',
                                                        'bike_img_2' => 'Image 2',
                                                        'bike_img_3' => 'Image 3',
                                                        'bike_img_4' => 'Image 4',
                                                        'bike_img_5' => 'Image 5',
                                                    ];
                                                    $fextn = [
                                                        'image'      => ['tag'=>'img',    'extn'=>['jpg','jpeg','png'], 'useFReader'=>true],
                                                    ];

                                                @endphp

                                                @foreach ($documents as $field => $label)
                                                    @php
                                                        $file = $data['item']->$field ?? null;
                                                        $fileName = $file ?: 'placeholder.png';
                                                        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                                                        $src = asset('public/uploads/bike-purchases/' . $fileName);
                                                        foreach ($fextn as $cat => $con) {
                                                            if (in_array($extension, $con['extn'])) {
                                                                $tag = $con['tag'];
                                                                break;
                                                            }
                                                        }
                                                    @endphp
                                                    <div class="col-sm-2 col-md-2 col-lg-2 text-center">
                                                        <label class="file-preview-label" for="{{ $field }}">
                                                            {{ $label }}
                                                            @if ($con['useFReader'])
                                                                <{{ $tag }} id="{{ $field }}_view" class="file-preview" src="{{ $src }}">
                                                            @else
                                                                <{{ $tag }} id="{{ $field }}_view" class="file-preview">{{ strtoupper($extension) }}</{{ $tag }}>
                                                            @endif
                                                            <input type="file" 
                                                                class="file-input d-none" 
                                                                id="{{ $field }}" 
                                                                name="{{ $field }}" 
                                                                accept="*/*">
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>








                                            public function bikeImageUpload($attr_id, $data)
    {
        foreach($data['image'] as $image){
            if($image){
                $img_name = Str::uuid().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('uploads/'. 'new-bikes-imgs'), $img_name);
                BikeAttributeImage::create(['image'=> $img_name, 'attribute_id'=> $attr_id]);
            }
        }
    }


        public function createBikeAttribute($data)
    {
        $images = $data['images'];
        unset($data['images']);
        $ba = BikeAttribute::where($data)->first();
        if(!$ba){
            $ba = BikeAttribute::create($data);
            $this->bikeImageUpload($ba->id,$images);
        }
        return $ba->id;
    }