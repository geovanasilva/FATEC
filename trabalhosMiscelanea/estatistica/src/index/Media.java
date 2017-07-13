/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package index;

/**
 *
 * @author barbaromatrix
 */
public class Media {
    
    public Media(){}
    
    /**
     * 
     * @param elementos
     * @return Média simples de um conjunto de elementos
     */
    public double media(double[] elementos){
        int soma = 0;
        soma = (int)soma(elementos, elementos.length - 1);
        return soma/elementos.length;
    }
    
    /**
     * 
     * @param elementos
     * @param frequencia
     * @return média de x intervalos de classe de um conjunto de dados
     */
    public double media(double[] elementos, double[] frequencia){
        return 0;
    }
    
    public void arredondaNumero(String numero){
        
    }
    
    /**
     * 
     * @param f
     * @param controle
     * @return soma recursiva do vetor f
     */
    public double soma(double[] f, int controle)
    {
        if(controle == 0) return f[0];
        
        return f[controle] + soma(f, controle - 1);
    }
}