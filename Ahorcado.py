"""
ANDRES VILLARRUEL
Transcribiendo el ahorcado(PHP) en Python para aprender el lenguaje.
"""

#Menu de juego------------------------------------------------------
from random import randint


def menuInicial():
    """
    Menu inicial del juego 
    """
    print ("\n------------------------------------------------------------")
    print ("\n ( 1 ) Jugar con una palabra aleatoria")
    print ("\n ( 2 ) Jugar con una palabra elegida")
    print ("\n ( 3 ) Agregar palabra al listado")
    print ("\n ( 4 ) Mostrar la informacion completa de un numero de juego")
    print ("\n ( 5 ) Mostrar la informacion del primer juego con mas puntaje")
    print ("\n ( 6 ) Mostrar el primer puntaje que supere un resultado escrito por el usuario")
    print ("\n ( 7 ) Mostrar lista de palabras ordenadas por puntaje")
    print ("\n ( 8 ) Restar un numero a mayor puntaje(Solo se puede usar despues de usar anteriormente la opcion 5)")
    print ("\n ( 9 ) Salir")
    print ("\n------------------------------------------------------------\n")

    optionSelectSTR = input()
    while True:
        if optionSelectSTR.isnumeric():
            optionSelect = int(optionSelectSTR)#Convertir
            intNum = isinstance(optionSelect, int)#Testea la conversion devolviendo booleano
            if intNum and (optionSelect > 0 and optionSelect <= 9):#Si es numero
                break
            else:
                print ("\n------------------------------------------------------------\n")
                print ("\nIngrese opcion valida\n")    
                optionSelectSTR = input()  
        else:
            print ("\n------------------------------------------------------------\n")
            print ("\nIngrese opcion valida\n")    
            optionSelectSTR = input()
    
    return optionSelect


#Coleccion de palabras
def cargarPalabras():
    coleccionPalabras = []
    coleccionPalabras[0] = {"palabra": "papa" , "pista": "se cultiva bajo tierra", "puntosPalabra":7}
    coleccionPalabras[1] = {"palabra": "hepatitis" , "pista": "enfermedad que inflama el higado", "puntosPalabra": 7}
    coleccionPalabras[2] = {"palabra": "volkswagen" , "pista": "marca de vehiculo", "puntosPalabra": 10}
    coleccionPalabras[3] = {"palabra": "precambrica" , "pista": "es una división informal de la escala temporal geológica, es la primera y más larga etapa de la historia de la Tierra ", "puntosPalabra": 100}
    coleccionPalabras[4] = {"palabra": "dignidad" , "pista": "cualidad de digno", "puntosPalabra": 10}
    coleccionPalabras[5] = {"palabra": "mineral" , "pista": "solido de estructura cristalina", "puntosPalabra": 10}
    coleccionPalabras[6] = {"palabra": "hipopotomonstrosesquipedaliofobia" , "pista": "miedo irracional a la pronunciación de las palabras largas ", "puntosPalabra": 100}
    return coleccionPalabras


#Jugar con palabra aleatoría
# min, max int
def indiceAleatorioEntre(min, max):
    aleatorio = randint(min, max)
    return aleatorio


#Solicitar un valor para calcular la palabra aleatoria
def solicitarIndiceEntre(min, max):
    while True:
        print ("------------------------------------------------------------")
        print (f"\nSeleccione un valor entre:{min} y {max}\n")
        optionSelectSTR = input()
        if optionSelectSTR.isnumeric():
            optionSelect = int(optionSelectSTR)#Convertir
            intNum = isinstance(optionSelect, int)#Testea la conversion devolviendo booleano
            if intNum and (optionSelect > min and optionSelect <= max):#Si es numero
                break
    return optionSelect


#Inicio del juego
def jugar(coleccionPalabras, indicePalabra, cantIntentos):
    palabra = coleccionPalabras[indicePalabra],{"palabra"}
    pista = coleccionPalabras[indicePalabra],{"pista"}
    coleccionLetras = dividirPalabraEnLetras(palabra)
    puntaje = 0
    palabraDescubierta = False
    palabra = stringLetrasDescubiertas(coleccionLetras)
    acumuladorLetras = ''
    print ("------------------------------------------------------------")
    print (f"\n{pista}\n")
    print (f"{palabra}\n")

    