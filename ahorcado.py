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
    coleccionPalabras =[    {"palabra": "papa" , "pista": "se cultiva bajo tierra", "puntosPalabra":7},
                            {"palabra": "hepatitis" , "pista": "enfermedad que inflama el higado", "puntosPalabra": 7},
                            {"palabra": "volkswagen" , "pista": "marca de vehiculo", "puntosPalabra": 10},
                            {"palabra": "precambrica" , "pista": "es una división informal de la escala temporal geológica, es la primera y más larga etapa de la historia de la Tierra ", "puntosPalabra": 100},
                            {"palabra": "dignidad" , "pista": "cualidad de digno", "puntosPalabra": 10},
                            {"palabra": "mineral" , "pista": "solido de estructura cristalina", "puntosPalabra": 10},
                            {"palabra": "hipopotomonstrosesquipedaliofobia" , "pista": "miedo irracional a la pronunciación de las palabras largas ", "puntosPalabra": 100}
                        ]
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
    palabra = coleccionPalabras[indicePalabra]["palabra"]
    pista = coleccionPalabras[indicePalabra]["pista"]
    coleccionLetras = dividirPalabraEnLetras(palabra)
    puntaje = 0
    palabraDescubierta = False
    palabra = stringLetrasDescubiertas(coleccionLetras)
    acumuladorLetras = ''
    print ("------------------------------------------------------------")
    print (f"\n{pista}\n")
    print (f"{palabra}\n")

    continuar = True
    while continuar:
        letraSeleccionada = solicitarLetra()
        fueUsada = usada(letraSeleccionada, acumuladorLetras)
        if fueUsada:
            print ("------------------------------------------------------------")
            print ("\nPruebe una letra que no haya usado\n")
        else:
            letraExistente = existeLetra(coleccionLetras, letraSeleccionada)   
            if letraExistente == True:
                coleccionLetras = destaparLetra(coleccionLetras, letraSeleccionada)
                palabra = stringLetrasDescubiertas (coleccionLetras)
                acumuladorLetras = acumuladorLetras + letraSeleccionada.upper()
            else:
                cantIntentos -= 1
                acumuladorLetras = acumuladorLetras + letraSeleccionada.upper()
                print (f"\nLetra erronea...{letraSeleccionada} No pertenece a la palabra.\n")
            print ("------------------------------------------------------------")
            print (f"\n \n {palabra.upper()}\n \n")
            print (f"{pista}\n")
            print (f"Ya probaste con {acumuladorLetras}\n(Mayusculas: correctas, minusculas: error)\n")    
            if cantIntentos > 0:
                print (f"Quedan {cantIntentos} intentos\n")
        palabraFueDescubierta = palabraDescubierta(coleccionLetras)    
        if palabraDescubierta:
            puntaje = (coleccionPalabras[indicePalabra]["puntosPalabra"]) + cantIntentos
            print ("------------------------------------------------------------\n")
            print (palabra.upper())
            print (f"\n¡¡¡GANASTE!!!! {puntaje} puntos.")
            continuar = False
        if cantIntentos == 0:
            print ("------------------------------------------------------------\n")
            print ("No quedan intentos... Perdiste.")
            continuar = False
    return puntaje