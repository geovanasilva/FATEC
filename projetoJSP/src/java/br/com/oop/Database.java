/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package br.com.oop;

import java.util.ArrayList;

/**
 *
 * @author root
 */
public class Database {
    private static ArrayList<Pessoa> pessoas = new ArrayList<>();
    private static ArrayList<Fornecedor> fornecedor = new ArrayList<>();
    
    /**
     * @return 
     */
    public static ArrayList<Pessoa> getPessoasList() {
        return pessoas;
    }
    
    public static ArrayList<Fornecedor> getFornecedorList()
    {
        return fornecedor;
    }
    
    public static Object select(String tableName)
    {
        if(tableName.equals("pessoa"))
            return pessoas;
        else if(tableName.equals("fornecedor"))
            return fornecedor;
        else
            return new ArrayList<>();
    }
    
    public static Object select(String tableName, int index)
    {
        if(tableName.equals("pessoa"))
            return pessoas.get(index);
        else if(tableName.equals("fornecedor"))
            return fornecedor.get(index);
        else
            return false;
    }
    
    public static boolean insert(String tableName, Object dados)
    {
        if(tableName.equals("pessoa"))
            return pessoas.add((Pessoa)dados);
        else if(tableName.equals("fornecedor"))
            return fornecedor.add((Fornecedor)dados);
        else
            return false;
    }
    
    public static boolean update(String tableName, String[] dados, int index)
    {
        if(tableName.equals("pessoa"))
        {            
                Pessoa p = pessoas.get(index);
                p.setNome(dados[0]);
                p.setEmail(dados[1]);
                p.setTelefone(dados[2]);
                p.setEndereco(dados[3]);
                p.setCpf(dados[4]);
                p.setRg(dados[5]);
                return true;
        }
        else if(tableName.equals("fornecedor"))
        {
            Fornecedor f = fornecedor.get(index);
                
                f.setNome(dados[0]);
                f.setEmail(dados[1]);
                f.setTelefone(dados[2]);
                f.setEndereco(dados[3]);
                f.setCnpj(dados[4]);
                f.setNome_social(dados[5]);
                return true;
        }
        else
            return false;
    }
    
    public static boolean delete(String tableName, int index)
    {
        if(tableName.equals("pessoa"))
        {
            pessoas.remove(index);
            return true;
        }
        else if(tableName.equals("fornecedor"))
        {
            fornecedor.remove(index);
            return true;
        }
        else
            return false;
    }
}
