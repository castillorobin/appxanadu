<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Controles</title>
    <style>
          table {
            width: 100%;
  
}
        table, th, td {
            border-collapse: collapse;
  border: 1px solid;
}
    </style>
</head>
<body>
    <div style="width: 1000px; text-align: center;">
    <h1 style="">Automotel Xanadu</h1>
    </div>
    
    <input type="text" value=" {{ $total = 0}}" style="display: none;">
    
    <table >
                        <thead >
                            <tr >
                                
                                <th >Fecha</th>
                                <th >Vehiculo</th>
                                <th >Placa</th>
                                <th >Habitacion</th>
                                <th >Entrada</th>
                                <th >Salida</th>
                                <th >Tarifa</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            
                            @for ($i=0; $i< count($controles); $i++)
                            @if($controles[$i]->estado == 0)
                            
                            <tr >
                            <td>{{ date('d/m/Y', strtotime($controles[$i]->created_at))  }}</td>
                           
                            <td>{{ $controles[$i]->vehiculo }}</td>
                            <td>{{ $controles[$i]->placa }}</td>
                            <td>{{ $controles[$i]->habitacion }}</td>
                            <td>{{ $controles[$i]->entrada }}</td>
                            <td>{{ $controles[$i]->salida }}</td>
                            <td>${{ $controles[$i]->tarifa }}</td>
                        
                            
                            </tr>
                            <input type="text" value=" {{ $total= $total + $controles[$i]->tarifa }}" style="display: none;">
                            @endif
                            @endfor
                            <tr>
                                <td colspan="6" style="text-align: right;">Total &nbsp; </td>
                                <td > $ {{ $total }}</td>
                            </tr>
                        </tbody>
                        
                        </table>

</body>
</html>