/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package convertciudades;

/**
 *
 * @author arturv
 */
public class Provincia {
    private int idprovincia;
    private String nombre;
    
    public Provincia(int idprovincia,String nombre)
    {
        this.idprovincia = idprovincia;
        this.nombre=nombre;
    }
    
    public int getidprovincia()
    {
        return idprovincia;
    }
    
    public void setidprovincia(int idprovincia)
    {
        this.idprovincia=idprovincia;
    }
    
    public String getnombre()
    {
        return nombre;
    }
    
    public void setnombre(String nombre)
    {
        this.nombre=nombre;
    }
}
