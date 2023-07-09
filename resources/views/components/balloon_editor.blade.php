@props(['focus' => false])

<div class=" border-b" wire:ignore 
                x-data="{
                    message:@entangle($attributes->wire('model')).defer,
                    isFocus:false,
                }"
                x-init="
                    $watch('message', value => {
                        if (!value){
                            ballonEditor.setData('');
                        }
                    });
                    BalloonEditor
                    .create( $refs.MyEditor )
                    .then( editor => {

                        ballonEditor = editor;

                        if (message){
                            editor.setData(message);{{-- Con esto me traigo lo que tenga message --}}
                        }

                        @if ($focus)
                            editor.focus();
                            isFocus = true;
                        @endif
                        
                        editor.model.document.on('change:data', () => {
                            message = editor.getData();{{-- Con esto reemplazo --}}
                        });

                        editor.editing.view.document.on('change:isFocused', (evt, data, isFocused) => {
                            isFocus = isFocused;
                        });
                    })
                    .catch( error => {
                        console.error( error );
                });
                ">
                    <div x-ref="MyEditor" x-bind:class="isFocus ? 'bg-white' : '' "></div>
</div>