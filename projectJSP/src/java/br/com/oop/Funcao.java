/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package br.com.oop;

/**
 *
 * @author Usuario
 */
public class Funcao {
    /**
     * 
     * @param strCpf
     * @return Verifica se CPF é válido
     */
    public static boolean verificaCpf(String strCpf) {
        int soma;
        int resto;
        soma = 0;
        if (strCpf.equals("00000000000")) {
            return false;
        }

        for (int i = 1; i <= 9; i++) {
            soma = soma + Integer.parseInt(strCpf.substring(i - 1, i)) * (11 - i);
        }

        resto = soma % 11;

        if (resto == 10 || resto == 11 || resto < 2) {
            resto = 0;
        } else {
            resto = 11 - resto;
        }

        if (resto != Integer.parseInt(strCpf.substring(9, 10))) {
            return false;
        }
        soma = 0;

        for (int i = 1; i <= 10; i++) {
            soma = soma + Integer.parseInt(strCpf.substring(i - 1, i)) * (12 - i);
        }
        resto = soma % 11;

        if (resto == 10 || resto == 11 || resto < 2) {
            resto = 0;
        } else {
            resto = 11 - resto;
        }

        return resto == Integer.parseInt(strCpf.substring(10, 11));
    }
    
}
