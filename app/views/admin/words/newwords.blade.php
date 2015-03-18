@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
    {{{ $title }}} :: @parent
@stop

{{-- Content --}}
@section('content')
    <div class="page-header">
        <h3>
            {{{ $title }}}

            <div class="pull-right">
                 <a class="btn btn-default btn-small btn-inverse" href="{{{ URL::to('admin/movie/'.$movie->id.'/view') }}}"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
            </div>
        </h3>
    </div>
    <form class="form-horizontal" enctype="multipart/form-data" method="post">
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
        <div class="form-group">
            <div class="col-xs-offset-2 col-xs-10">
                <button type="submit" class="btn btn-primary" style="float:right">Submit</button>
            </div>
        </div>
        <table id="sentiments" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th class="col-md-2">Word</th>    
                    <th class="col-md-2">{{{ Lang::get('table.actions') }}}</th>
                </tr>
                @if(!empty($newWords))
                    <?php $i =0 ?>
                    @foreach($newWords as $word)
                        
                        <tr>
                            <td class="col-md-2">{{ $word }}</td>    
                            <td class="col-md-2">
                                <input type="hidden" class="form-control" id="inputWord{{$i}}" name="word[{{$i}}][word]" value='{{ $word }}'>
                                <div class="form-group">
                                    <label for="inputImg" class="control-label col-xs-3" style="text-align:left">Word Type</label>
                                    <div class="col-xs-7">
                                        <select class="form-control js-word-type" data-index="{{ $i }}" name="word[{{$i}}][word_type_id]">
                                             @foreach ($word_types as $word_type)
                                                <option value="{{{ $word_type->id }}}" {{{ ( $word_type->id == 4  ? ' selected="selected"' : '') }}} >{{{ $word_type->type }}}</option>
                                            @endforeach
                                        </select>
                                     </select>
                                    </div>
                                </div>
                                <div class="form-group js-category-{{$i}} hide">
                                    <label for="inputImg" class="control-label col-xs-3"  style="text-align:left">Category</label>
                                    <div class="col-xs-7">
                                        <select class="form-control  " name="word[{{$i}}][category_id]">
                                             @foreach ($categories as $category)
                                                <option value="{{{ $category->id }}}" {{{ ( $category->id == Input::old('category_id')  ? ' selected="selected"' : '') }}} >{{{ $category->meaning }}}</option>
                                            @endforeach
                                        </select>
                                     </div>
                                </div>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    @endforeach
                @else
                    <tr><td cols='2'>No New Words Found</td></tr>
                @endif
            </thead>
            <tbody>
            </tbody>
        </table>
        <div class="form-group">
            <div class="col-xs-offset-2 col-xs-10">
                <button type="submit" class="btn btn-primary" style="float:right">Submit</button>
            </div>
        </div>
    </form>
@stop

{{-- Scripts --}}
@section('scripts')
    <script type="text/javascript">
        var oTable;
        $(document).ready(function() {
              $('.js-word-type').change(function(e){
                    val = $(this).val();

                    index = $(this).data('index');
                    if(val == 1)
                    {
                        $('.js-category-'+index).removeClass('hide');
                    }
                    else
                    {
                        $('.js-category-'+index).addClass('hide');
                    }
                    
              });
        });
    </script>
@stop