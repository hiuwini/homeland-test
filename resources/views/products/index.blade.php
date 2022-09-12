@extends('layouts.master')

@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/pickadate/classic.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/pickadate/classic.date.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
@endsection

@section('main-content')
    <div class="breadcrumb">
        <h1>Productos</h1>
        <ul>
            <li><a href=""></a>Productos</li>
            <li>Homeland</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="row mb-4">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary m-1" id="createProduct" data-toggle="modal" data-target="#productModal" >
                <span class="ul-btn__icon"><i class="i-Add"></i></span>
                <span class="ul-btn__text">Agregar Producto</span>
            </button>
        </div>
    </div>
    <!-- end of row -->

    <div class="row mb-4">

        <div class="col-md-12 mb-4">
            <div class="card text-left">

                <div class="card-body">
                    <h4 class="card-title mb-3">Listado de productos</h4>

                    <div class="table-responsive">
                        <table id="products_table" class="display table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Ingreso</th>
                                    <th>Vencimiento</th>
                                    <th>Fotografia</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($products as $key=>$product)
                                <tr>
                                    <td>{{ $product->code }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->entry_date }}</td>
                                    <td>{{ $product->due_date }}</td>
                                    <td> <img src="/image/{{ $product->picture }}" width="100px"> </td>
                                    <td>
                                        <a href="#" class="text-success mr-2">
                                            <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                        </a>
                                        <a href="#" class="text-danger mr-2">
                                            <i class="nav-icon i-Close-Window font-weight-bold" data-toggle="modal" data-target="#product_remove"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>


                        </table>
                    </div>

                </div>
            </div>
        </div>
        <!-- end of col -->

        <!-- Form Create & Update -->
        <div class="modal fade bd-example-modal-lg" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModal" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_title">Nuevo Producto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="form-product">
                                    @method('POST')
                                    @csrf
                                    <div class="form-row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="product_cod" class="col-form-label">Código de producto</label>
                                            <input type="text" class="form-control" id="product_cod" name="product_cod" required>
                                            <div class="invalid-tooltip">
                                                Please provide a valid city.
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="product-name" class="col-form-label">Nombre de producto</label>
                                            <input type="text" class="form-control" id="product_name" name="product_name" required>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="product-quantity" class="col-form-label">Cantidad</label>
                                            <input type="number" class="form-control" id="product_quantity" name="product_quantity" required>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="product-price" class="col-form-label">Precio</label>
                                            <input type="number" class="form-control" id="product_price" name="product_price" required>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="product-entrydate">Fecha de ingreso</label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <button class="btn btn-secondary"  type="button">
                                                        <i class="icon-regular i-Calendar-4"></i>
                                                    </button>
                                                </div>
                                                <input id="product_entrydate" type="date" class="form-control" placeholder="dd/mm/yyyy" name="product_entrydate" required >

                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="product_duedate">Fecha de vencimiento</label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <button class="btn btn-secondary"  type="button">
                                                        <i class="icon-regular i-Calendar-4"></i>
                                                    </button>
                                                </div>
                                                <input id="product_duedate" type="date" class="form-control" placeholder="dd/mm/yyyy" name="product_duedate" required >

                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="product-picture">Fotografía</label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" id="product_picture" name="product_picture" required>
                                            </div>
                                        </div>
                                        <input type="hidden" id="typeAction" name="typeAction">
                                        <input type="hidden" id="product_id" name="product_id">
                                    </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="actionProduct">Crear</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Form Create & Update -->

        <!-- Modal Confirmation Delete -->
        <div class="modal fade" id="product_remove" tabindex="-1" role="dialog" aria-labelledby="product_remove" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="product_modal_delete">Confirmar de eliminación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4>¿Estas seguro que deseas eliminar este producto?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="delete_product_button">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal Confirmation Delete -->

    </div>
    <!-- end of row -->



@endsection

@section('page-js')

    <script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables.script.js')}}"></script>
    <script src="{{asset('assets/js/vendor/pickadate/picker.js')}}"></script>
    <script src="{{asset('assets/js/vendor/pickadate/picker.date.js')}}"></script>
    <script src="{{asset('assets/js/vendor/jquery-validation/jquery.validate.js')}}"></script>
    <script src="{{asset('assets/js/vendor/jquery-validation/additional-methods.js')}}"></script>

@endsection

@section('bottom-js')

    <script src="{{asset('assets/js/product.create.script.js')}}"></script>

@endsection

