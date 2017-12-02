import org.bukkit.entity.Player;

import java.sql.*;

public class coinsAPI {

    private String url_base, host, name, username, password, table;
    private Connection connection;

    public API(String url_base, String host, String name, String username, String password, String table){
        this.url_base = url_base;
        this.host = host;
        this.name = name;
        this.username = username;
        this.password = password;
        this.table = table;
    }

    public void connection(){
        //Fonction pour se connecter à la base de données
        if(!isConnected()){//On vérifie qu'on est pas déjà connecter !
            try {
                //On charge les drivers pour établir la connection
                connection = DriverManager.getConnection(url_base + host + "/" + name, username, password);
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
    }

    public void deconnection(){//Fonction de deconexion
        if(isConnected()){//On vérifie qu'on est connecté
            try {
                connection.close();//On ferme la connexion
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
    }

    private boolean isConnected(){
        try {
            //On vérifie si la connexion est null, fermée ou Valide
            if((connection == null) || (connection.isClosed()) || (!connection.isValid(5))){
                //Si non, on return false
                return false;
            }else{
                return true;
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return false;
    }

    private Connection getConnection(){//FOnction pour récupérer la connexion
        return connection;
    }

    public void createPlayerIfNotExist(Player player){
        try {
            PreparedStatement sts = getConnection().prepareStatement("SELECT COUNT(*) FROM "+table+" WHERE uuid = ?");
            sts.setString(1, player.getUniqueId().toString());
            ResultSet rs = sts.executeQuery();
            if(!rs.next()){
                sts.close();
                sts = getConnection().prepareStatement("INSERT INTO "+table+" (uuid, coins) VALUES (?, ?)");
                sts.setString(1, player.getUniqueId().toString());
                sts.setInt(2, 0);
                sts.executeUpdate();
                sts.close();
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    public void addCoins(String uuid, int coins){//On ajoute des points au joueurs avec l'udid du joueur + le nombre de points à rajouter
        try {
            PreparedStatement sts = getConnection().prepareStatement("UPDATE "+table+" SET coins = coins + ? WHERE uuid = ?");//Requete pour ajouté des points
            sts.setInt(1, coins);
            sts.setString(2, uuid);
            sts.executeUpdate();
            sts.close();
        } catch (SQLException e) {
            e.printStackTrace();
        }

    }

    public void removeCoins(String uuid, int coins){
        try {
            PreparedStatement sts = getConnection().prepareStatement("UPDATE "+table+" SET coins = coins - ? WHERE uuid = ?");//Requete pour supprimer des coins
            sts.setInt(1, coins);
            sts.setString(2, uuid);
            sts.executeUpdate();
            sts.close();
        } catch (SQLException e) {
            e.printStackTrace();
        }

    }
    public Integer getPoints(String uuid){
        try {
            PreparedStatement sts = getConnection().prepareStatement("SELECT coins FROM "+table+" WHERE uuid = ?");//Requete pour récupérer des coins
            sts.setString(1, uuid);
            ResultSet rs = sts.executeQuery();
            if(!rs.next()){
                return 0;
            }
            sts.close();
            return rs.getInt("coins");
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return  0;
    }

}
