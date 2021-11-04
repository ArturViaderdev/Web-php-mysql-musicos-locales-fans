
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 <?php
 require_once 'bbdd.php';
 ?>
 <form method="post" action="provincias.php">
    <td><select id="provincia" name="provincia">
                                                <?php
                                                $provincias = dimeprovincias();
                                                $cont = 0;
                                                while ($fila = mysqli_fetch_assoc($provincias)) {
                                                    extract($fila);
                                                    if ($cont == 0) {
                                                        $primeraprovincia = $provincia;
                                                        $cont++;
                                                    }
                                                    $provincia = utf8_encode($provincia);
                                                    echo"<option value='$provincia'>$provincia</option>";
                                                }
                                                ?>

                                            </select>
                                        </td>
                                     
                                    </tr>
                                            
                                    <input type="submit" value="enviar">                                     
</form>