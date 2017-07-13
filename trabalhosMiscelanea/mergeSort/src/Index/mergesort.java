/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Index;

import java.util.Arrays;



/**
 *
 * @author barbaromatrix
 */
public class mergesort {
     public static void main(String[] args) {
        int[] list = {14, 32, -67, 76, 23, 41, 580, 85};
        
         System.out.println("Antes: \t\t" + Arrays.toString(list));
         
         System.out.println("");
        mergeSort(list);
        System.out.println("Depois: \t" + Arrays.toString(list));
    }

    // Places the elements of the given array into sorted order
    // using the merge sort algorithm.
    // post: array is in sorted (nondecreasing) order
    public static void mergeSort(int[] array) {
        if (array.length > 1) {
            // split array into two halves
            int mid = array.length / 2;
            int[] left = new int[mid];
            
            for (int i = 0; i < left.length; i++) {
                left[i] = array[i];
            }
            
            int[] right = new int[array.length - mid];
            for (int i = 0; i < right.length; i++) {
                right[i] = array[i + mid];
            }
            // recursively sort the two halves
            mergeSort(left);
            mergeSort(right);
            
            // merge the sorted halves into a sorted whole
            merge(array, left, right);
        }
    }
    
    public static void merge(int[] result,int[] left, int[] right) {
        int i1 = 0;   
        int i2 = 0;   
        
        for (int i = 0; i < result.length; i++) {
            if (i1 < left.length && i2 < right.length) {
                if(left[i1] < right[i2]){
                    result[i] = left[i1]; 
                    i1++;
                }else{
                    result[i] = right[i2];
                    i2++;
                }
            }else if(i1 < left.length){
                result[i] = left[i1]; 
                i1++;
            }else{
                result[i] = right[i2]; 
                i2++;
            }
        }
    }
}
