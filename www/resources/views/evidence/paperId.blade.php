@extends('home')
@section('style')
    <style>
        input {
            border: 1px solid ;
            border-color: #CCCCCC!important;
            width: 100%;
            color: black !important;
            padding-left: 2px;
            border-radius: 3px !important;

        }

        .colorLabel {

            background-color: #fafafa !important;
            font-weight: bold
        }

        .colorLabelTwo {
            background-color: #ffffff !important;
        }
    </style>
@endsection
@section('content')
    <div class="container"> <div class="col col-md-4">
            @foreach($document_photo as $document_photos)
                <img src="{{asset('image/paper/'.$document_photos->name)}}">
            @endforeach
        </div>
        @foreach($edit_document as $edit_documents)
            <div class="col col-md-8">
                <form method="post" action="{{url('changeBasicInfo/'.$edit_documents->edit_id)}}">
                    @csrf
                    <table class="footable table table-striped table-bordered table-white table-primary">
                        <tbody>
                        <tr>
                            <td class="colorLabel" colspan="2" style="text-align: right">
                                <button style="padding:5px;border-radius: 4px" type="submit"
                                        class="btn btn-xs btn-primary">Uložiť
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="colorLabel" style="width: 120px;">Názov</td>
                            <td class="colorLabelTwo"><input required name="company_name" type="text"
                                                             value=" {{$edit_documents->company_name}}">
                            </td>
                        </tr>
                        <tr>
                            <td class="colorLabel">Adresa</td>
                            <td class="colorLabelTwo"><input  required name="company_address" type="text"
                                                             value=" {{$edit_documents->company_address}}">
                            </td>
                        </tr>
                        <tr>
                            <td class="colorLabel">IČO</td>
                            <td class="colorLabelTwo"><input required type="text" name="ico" value="{{$edit_documents->ico}}">
                            </td>
                        </tr>
                        <tr>
                            <td class="colorLabel" name="ic_dph">IČ Dph</td>
                            <td><input required name="ic_dph" type="text"
                                       value=" {{$edit_documents->ic_dph}}">
                            </td>
                        </tr>
                        <tr>
                            <td class="colorLabel"  name="dpk" >DPK</td>
                            <td><input  required name="dpk" style="margin-top: 5px;" type="number"
                                       value="{{$edit_documents->dpk}}"></td>
                        </tr>
                        <tr>
                            <td class="colorLabel">Dátum</td>
                            <td class="colorLabelTwo"><input required name="date" type="date"
                                                             value="{{$edit_documents->date}}"></td>
                        </tr>
                        <tr>
                            <td class="colorLabel">Mena</td>
                            <td class="colorLabelTwo">EUR</td>
                        </tr>
                        <tr>
                            <td class="colorLabel">Suma (s DPH)</td>
                            <td class="colorLabelTwo"><input type="text"name="sumar" required
                                                             value="{{$edit_documents->summar}}"></td>
                        </tr>

                        </tbody>
                    </table>
                </form>
                <form method="post" action="{{url('changeItems/'.$edit_documents->edit_id)}}">
                    @csrf
                    <table class="footable table table-striped table-bordered table-white table-primary">
                        <tbody>
                        <tr>
                            <td class="colorLabel" colspan="4">
                                <span style="text-align: left !important;">Položky</span>
                                <button style="border-color:#3f8Fd2!important;background-color: #3f8Fd2!important;float:right;padding:5px;border-radius: 4px" type="submit"
                                        class="btn btn-xs btn-primary">Opraviť
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <th class="colorLabel" style="width: 60%">Názov</th>
                            <th class="colorLabel" style="text-align: center">Ks</th>
                            <th class="colorLabel" style="text-align: center">Cena(EUR)</th>
                            <th class="colorLabel" style="text-align: center"></th>

                        </tr>


                        @foreach($edit_item as $edit_items)
                        <tr>
                            <td class="colorLabelTwo"  style="width: 60%"><input name="{{$edit_items->id}}_name" required type="text" value="{{$edit_items->name}}"> </td>
                            <td class="colorLabelTwo"><input name="{{$edit_items->id}}_quantity"  style="text-align: center" required type="text"
                                                             value=" {{$edit_items->quantity}}">
                            </td>
                            <td class="colorLabelTwo"><input name="{{$edit_items->id}}_price"  style="text-align: center" required  type="text"
                                                             value=" {{$edit_items->price}}">
                            </td>

                            <td class="colorLabelTwo"><form action="{{url('delItem/'.$edit_items->id)}}"><button type="submit" name="delete_btn" class="btn btn-xs btn-danger btn_delete">x
                                </button> </form>
                            </td>
                        </tr>

                        </tbody>
                        @endforeach
                    </table>
                </form>
                <form method="post" action="{{url('addItem/'.$id)}}">
                    @csrf
                    <table class="footable table table-striped table-bordered table-white table-primary">
                        <tbody>
                        <tr>
                            <td class="colorLabel" colspan="3">
                                <span style="text-align: left !important;">Pridať položku</span>
                                <button style="float:right;padding:5px;border-radius: 4px" type="submit"
                                        class="btn btn-xs btn-primary">Pridať
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <th class="colorLabel" style="width: 60%">Názov</th>
                            <th class="colorLabel" style="text-align: center">Ks</th>
                            <th class="colorLabel" style="text-align: center">Cena(EUR)</th>

                        </tr>



                            <tr>
                                <td class="colorLabelTwo"  style="width: 60%"><input name="name" required type="text"> </td>
                                <td class="colorLabelTwo"><input name="quantity"  style="text-align: center" required type="text">
                                </td>
                                <td class="colorLabelTwo"><input name="price"  style="text-align: center" required   type="text">
                                </td>

                            </tr>

                        </tbody>
                    </table>
                </form>
                @if(Auth::user()->getRights(Auth::user()->id)==2)
                <form method="post" action="{{url('documentInfo/'.$edit_documents->edit_id)}}">
                    @csrf
                    @foreach($document as $doc)
                        <table class="footable table table-striped table-bordered table-white table-primary">
                            <tbody>
                            <tr>
                                <td class="colorLabel" colspan="2">
                                    Info dokument
                                    <button style="border-color:#3f8Fd2!important;background-color: #3f8Fd2!important;float:right;padding:5px;border-radius: 4px" type="submit"
                                            class="btn btn-xs btn-primary">Opraviť
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="colorLabel" style="width: 120px;">Názov</td>
                                <td class="colorLabelTwo"><input required name="documentName" type="text"
                                                                 value=" {{$doc->name}}">
                                </td>
                            </tr>
                            <tr>
                                <td class="colorLabel">Tag</td>
                                <td class="colorLabelTwo"><select class="form-control"
                                                                  style="margin-top:5px;min-width: 150px;max-width: 250px;display: initial!important;"
                                                                  name="tag">
                                        <option>{{$doc->tag}}</option>
                                        <?php foreach($tags as $tag) : ?>
                                        <option>{{$tag->tag}}</option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td class="colorLabel">Dátum</td>
                                <td class="colorLabelTwo"><input required name="documentDate" type="date"
                                                                 value="{{$doc->date}}"></td>
                            </tr>
                            </tbody>
                        </table>
                    @endforeach
                </form>
                    @endif
            </div>
        @endforeach
    </div>

    @if(Session::get('toast')=='delete')
        <script>
            $.toast({
                text: 'Položka bola vymazaná !',
                showHideTransition: 'fade',
                position: 'top-center',
                icon: 'error'
            });
        </script>
    @endif
    @if(Session::get('toast')=='add')
        <script>
            $.toast({
                text: 'Položka bola vytvorená !',
                showHideTransition: 'fade',
                position: 'top-center',
                icon: 'success'
            });
        </script>
        @endif
    <?php Session::forget('toast');
    ?>

@endsection