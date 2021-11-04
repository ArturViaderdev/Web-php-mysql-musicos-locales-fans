/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package ciudadesrepetidas;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.Statement;
import java.util.ArrayList;

/**
 *
 * @author arturv
 */
public class Ciudadesrepetidas {

    /**
     * @param args the command line arguments
     */
    
    private static void compruebarepetidas(ArrayList<String> ciudades)
    {
        int cont=0;
        ArrayList<String> vistas;
        vistas = new ArrayList<>();
        System.out.println("Ciudades repetidas.");
        for(String actual:ciudades)
        {
            if(vistas.indexOf(actual)<0)
            {
                vistas.add(actual);
            }
            else
            {
                System.out.println(actual);
            }
        }
        System.out.println("Fin");
    }
    
    public static void main(String[] args) {
        // TODO code application logic here
        try
        {
            Class.forName("com.mysql.jdbc.Driver");
            Connection conexion = DriverManager.getConnection ("jdbc:mysql://localhost/musica","arturv", "ticmysql82");
            Statement st = conexion.createStatement();
  
            ArrayList<String> ciudades;
            ciudades = new ArrayList<String>();
            ResultSet rs = st.executeQuery("SELECT * FROM ciudad;");
            while (rs.next())
            {
                ciudades.add(rs.getString("nombre"));
            }
            compruebarepetidas(ciudades);   
        }
        catch(Exception ex)
        {
              System.out.println(ex);
        }
    }
    
}
