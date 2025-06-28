<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cotizacion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
</head>
<body>

    

   
        <div class="row p-4">

            <div class="col-md-12 text-center">
                <h3>Factura</h3>
                
            </div>
            



                                                  
                    
             
        <div class="row">
    
            <div class="col-12 text-center">
             <h5>Santos Alberto Guerrero Beltran</h5>
                <h4>MOTEL XANADU</h4>
                <H5>Carretera a los Naranjos</H5>
            <H5>Cantón Cantarrana, Santa Ana</H5>
            <H5>Tel.: 2429-0920</H5>

    
            </div>
     <p></p>
            <table> 
                <tbody>
                <tr>
                    <td>
                        <span class="input-group-text border-0">Fecha: </span>
                    </td>
                    <td>
                        <input type="text" class="form-control border-0" id="fecha" name="fecha" value="{{date('d/m/Y',strtotime($cotiactual[0]->created_at))}}" readonly>
                    </td>
                </tr>

                <tr>
                    <td>
                        <span class="input-group-text border-0">Cliente: </span>
                    </td>
                    <td>
                        <input type="text" class="form-control border-0"  value="{{ $cotiactual[0]->cliente}}" readonly>
                    </td>
                </tr>

                <tr>
                    <td>
                        <span class="input-group-text border-0">NIT/DUI: </span>
                    </td>
                    <td>
                        <input type="text" class="form-control border-0" id="dui" name="dui" value="{{ $cotiactual[0]->DUI}}" readonly>
                    </td>
                </tr>

                <tr>
                    <td>
                        <span class="input-group-text border-0">Direccion: </span>
                    </td>
                    <td>
                        <input type="text" class="form-control border-0" id="direccion" name="direccion" value="{{ $cotiactual[0]->direccion}}" readonly>
                    </td>
                </tr>

            </tbody>

            </table>

                      
         <input type="text" class="form-control border-0" id="codigo" name="codigo" value="{{ $cotiactual[0]->codigo}}" hidden>
    
                     
            <div class="row">
    
                <div class="col-12">
                <div class="input-group">
                    
                    
                </div>
                </div>
    
    
            </div>
    
    
          
            <br>
    <hr>
    <table id="prove" class="text-center">
        <thead >
            <tr >
                
                <th scope="col">Detalle</th>
                <th scope="col">Cant.</th>
                <th scope="col">Precio</th>
                <th scope="col">Subtotal</th>
              
                
            </tr>
        </thead>
        <tbody>
            <input type="text" value="{{ $subtotal=0 }}" hidden>
            <input type="text" value="{{ $turismo=0 }}" hidden>
            
            
            @for ($i=0; $i< count($detalles); $i++)
            <tr >
            <td>{{ $detalles[$i]->descripcion }}</td>
           
            <td>{{ $detalles[$i]->cantidad }}</td>
            <td>${{ $detalles[$i]->preciouni }}</td>
            <td>${{ $detalles[$i]->total }}</td>
            <input type="text" value="{{ $subtotal = $subtotal + $detalles[$i]->total }}" hidden>
            
                   @if($detalles[$i]->descripcion == 'Habitacion')
       <input type="text" value="{{ $turismo= ($detalles[$i]->preciouni / 1.18) * 0.05 }}" hidden> 
        @endif
            </tr>
            @endfor

     
            
           
            <tr >
                <td style="text-align: center; border: 0px solid black; "></td>
                <td style="text-align: center; border: 0px solid black; "></td>
                
               
                <td style="text-align: center;">Subtotal: </td>
                <td style="text-align: center;">$ {{ round($subtotal,2 )}}</td>
              
            
               
                </tr>
                <tr >
                    <td style="text-align: center; border: 0px solid black; "></td>
                    <td style="text-align: center; border: 0px solid black; "></td>
                   
                    <td style="text-align: center; font-size:13px;">Impuesto Turismo: </td>
                    <td style="text-align: center;">$ {{ round($turismo,2)}}</td>
                  
                
                   
                    </tr>
                    <tr >
                        <td style="text-align: center; border: 0px solid black; "></td>
                        <td style="text-align: center; border: 0px solid black; "></td>
                       
                        <td style="text-align: center; ">Total: </td>
                        <td style="text-align: center;">$ {{ round( $subtotal + $turismo, 2)}}</td>
                      
                    
                       
                        </tr>    
        </tbody>
    
        </table>
                        
    <hr>
  <div class="text-center">
    <img src="https://upload.wikimedia.org/wikipedia/commons/d/d7/Commons_QR_code.png" alt="" style="width: 200px;">
</div>            
                    </div>
                </div>
            </div>
       
    </section>
    
    <script>
        
        window.print();
        setTimeout(saludos, 3000);
        
        function saludos(){
            window.location.href = '/facturacion';
        }
        
        </script>


</body>
</html>

