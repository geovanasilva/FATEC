package com.example.quiz;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class User {
    
    public static String currentUser;
  
    private static Map<String, ArrayList> users = new HashMap<>();
        
    public static String getCurrentUser() {
        return currentUser;
    }
    
    public User(){
            users = new HashMap<>();
    }
    
    public User(String pUser) {
        if (validateLogin(pUser))
            users.put(pUser, new ArrayList<>());
        else    
            currentUser = pUser;
    }
    
    private boolean validateLogin(String pUser) {
        return users.containsKey(currentUser);
    }
}
