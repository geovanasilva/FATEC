#include <cstdlib>
#include <iostream>

using namespace std;

int vet[ 10 ];
const int tam = 10;

void bubbleSort( )
{
    int i, j, aux;
    for (i = tam - 1; i >= 1; i--) {
        for (j = 0; j < i; j++) {
            if (vet[j] > vet[j + 1]) {
                aux = vet[j];
                vet[j] = vet[j + 1];
                vet[j + 1] = aux;
            }
        }
    }
}

int buscaBinaria (int iVet[], int tam, int escolhido) {
   int esquerda, meio, direita;                             
       esquerda = 0; direita = tam-1;                          
           while (esquerda <= direita) {                         
              meio = (esquerda + direita)/2;                         
                  if (escolhido == iVet[meio]) return meio;             
                  if (escolhido < iVet[meio]) direita = meio - 1;
                  else esquerda = meio + 1;                  
           }   
   return -1;
}

int main()
{
    for( int i = 0; i < tam; i++ )
    {
            cout << "Digite os valores: ";
            cin >> vet[i];
            
            cout << endl;
    }
    
    int escolhido;
    
    cout << "Entre com o valor a ser buscado: " <<endl;
    cin >> escolhido;
    
    bubbleSort( );
    
    int encontrado = buscaBinaria(vet,tam, escolhido);
    if(encontrado >= 0) 
         cout<<"Valor encontrado na posicao: " << encontrado <<endl;
    else cout<<"Valor nao encontrado." <<endl;
    system("pause");
    return 0;
}