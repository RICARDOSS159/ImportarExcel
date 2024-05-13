#inicial=1

#while inicial<=100:
# inicial=inicial+1
#  divisor3=inicial%3==0
#  divisor5=inicial%5==0
#  if(divisor3 & divisor5):
#    print("fizz buzz") 
#  elif(divisor3):
#    print("fizz")
#  elif(inicial%5==0):
#   print("buzz")   
#  else:
#    print(inicial) 



def esAnagrama(palabra1,palabra2):
    return sorted(palabra1)==sorted(palabra2)


cadena1=str(input("Ingrese la primera cadena:")).lower()
cadena2=str(input("Ingrese la segunda cadena:")).lower()
anagrama=esAnagrama(cadena1,cadena2)

if anagrama:
  
  print(cadena1 + " si es anagrama de " + cadena2)

else:
  print("No es un anagrama")





