/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


package convertciudades;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.Statement;
import java.util.ArrayList;

/**
 *
 * @author arturv
 */
public class Convertciudades {

    /**
     * @param args the command line arguments
     */
    
    private static String dimeprovincia(int id_provincia, ArrayList<Provincia> provincias)
    {
        boolean sal = false, encontrado = false;
        int cont=0;
        while(!sal)
        {
            if(cont<provincias.size())
            {
                if(id_provincia==provincias.get(cont).getidprovincia())
                {
                    encontrado=true;
                    sal=true;
                }
                else
                {
                    cont++;
                }
            }
            else
            {
                sal=true;
            }
        }
        if(encontrado)
        {
            return provincias.get(cont).getnombre();
        }
        else
        {
            return"////";
        }
    }
    
    private static String cambiacomillas(String texto)
    {
        String nuevo="";
        for(int cont=0;cont<texto.length();cont++)
        {
          if(texto.charAt(cont)=='\'')
          {
              nuevo+='\'';
          }
          nuevo+=texto.charAt(cont);
        }
        return nuevo;  
    }
    
    public static void main(String[] args) {
        // TODO code application logic here
        try
        {
            Class.forName("com.mysql.jdbc.Driver");
            Connection conexion = DriverManager.getConnection ("jdbc:mysql://localhost/musica","arturv", "ticmysql82");
            Statement st = conexion.createStatement();
  
            ArrayList<Provincia> provincias;
            provincias = new ArrayList<>();
            
            ResultSet rs = st.executeQuery("SELECT * FROM provincias;");
            Provincia elemento;
            while (rs.next())
            {
                elemento = new Provincia(rs.getInt("id_provincia"),rs.getString("provincia"));  
                provincias.add(elemento);
            }
           
            int cont=0;
           
            rs = st.executeQuery("SELECT * FROM municipios"); 
            String nombre;
            String provincia;
            Statement stdos = conexion.createStatement();
            
            while (rs.next())
            {
                nombre = cambiacomillas(rs.getString("nombre"));
                provincia =cambiacomillas(dimeprovincia(rs.getInt("id_provincia"),provincias));
                System.out.println("nombre="+nombre);
                System.out.println("provincia="+ provincia);
                System.out.println("----");
                System.out.println("INSERT INTO ciudad VALUES("+ cont +",'"+nombre+"','"+provincia+"');");
                stdos.executeUpdate("INSERT INTO ciudad VALUES("+ cont +",'"+nombre+"','"+provincia+"');");
                cont++;
            }
            rs.close();
            
        } catch (Exception e)
        {
            e.printStackTrace();
        }
    }
    
}
