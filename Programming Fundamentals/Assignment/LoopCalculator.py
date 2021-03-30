'''
William Cawley Gelling 
Assignment 2
'''
#This is the function for sum(x,y), returns the answer for x + y = 
def sum(x,y): 
    ans = x+y
    return (ans)

#This is the function for prod(x,y), returns the answer for x * y = 
def prod(x,y):

    #Setting ans = 0, as it is the identity for addition. 
    ans=0
    #we now add x to ans y times.
    for i in range(0,y): 
        ans = sum(ans,x)
    return(ans) 

#This is the function for exp(x,y), returns the answer for x^y = 
def exp(x,y):
    #setting ans to 1 as it is the identity for multiplication .
    ans = 1 

    #loop to multiply ans * x, y number of times 
    for i in range(0,y): 
        
        ans = prod(ans,x)

    return(ans)

#This is the function for modulo(x,y), returns the answer x mod y = 
def modulo(x,y): 
    #Starting a loop that returns x when x <= y. 
    while True: 
        # If x grater then y, then add the negative of y to x until it is smaller then y.           
        if x >= y: 
            #Use the sum function with a negative y.
            x = sum(x,-y) 
        
        else :
            return(x)

#Asks for an input 
#Checks if input  positive (Zero is neither positve nor negative so not taken)
#Returns the input when positive. 
def positive(x):
    while True: 
        ans = float(input("Please enter a positive number {0} = ".format(x) ))
        if ans > 0: 
            return(ans)
        else: 
            print("Please input a positive number")

#Designed to check if input is a whole number and positive.
#takes in string of x or y to tell user which they are inputing.
#Asks for an input, returns the integer verison. 
def wholeAndPositive(x): 
    #Loops until critiria is met and returns the ans. 
    while True: 

        ans = float(input("Please enter a whole positive number {0} = ".format(x) ))
        #Checking that the number is positive 
        if ans > 0:
            #Checking that it is a whole number.  
            if modulo(ans,1) == 0: 
                #returning the integer version. 
                return(int(ans))
            else: 
                print("Please make sure you input a whole number")
        else: 
            print("Please make sure you input a positive number")


#Now start the program
print("Welcome to the loop calculator")

#start while loop to continually run the programm until user quits. 
#this loop goes around until q is pressed. 
while True: 

    #Prints the main menu.
    #This is the unicode of the superscript for y used in the code \u02b8 
    print('''
This calaculator will calculate by only using the addition operator "+". 
Their are four functions you can use today. These are:

1)  The Sum (x + y). 
    Enter two numbers x and y, the addition of these will then be returned as your answer.

2)  The Product (x * y). 
    Enter a POSITIVE numbers x and a WHOLE POSITIVE number y.
    The multiplication of these numbers will then returned as your answer. 

3)  The Exponent (x\u02b8). 
    Enter two POSOTIVE WHOLE numbers x and y, x to the power of y will then be returned. 

4)  The Remainder (remainder after [x/y]). 
    Enter two POSOTIVE numbers x and y, the remainder of x/y will then be returned as your answer.

If you wish to quit the program please enter q. 
    ''' )

    #Ask the user to choose which function they would like to use. 
    ask = input("Please enter which function you would like to use 1,2,3,4 or q to quit: ")

    #Excepts both q and Q incase the person accidently has caps lock on and is trying to quit. 
    if ask == 'q' or ask == 'Q': 
        break 

    elif ask == '1':

        #Ask for the input of x and y, this can be negative or positive and a float.
        x = float(input("Please enter your first number x = "))
        y = float(input("Please enter your second number y = "))

        print(x, " + ", y, " = " , sum(x,y))

    elif ask == '2':

        #Asks for input and checks it is positive. 
        x = positive('x')

        #Asks for input and makes sure it is positive and an integer.
        y = wholeAndPositive('y')

        print(x, " * ", y, " = " , prod(x,y))

    elif ask == '3':

        #Asks for input and makes sure it is  positive and an integer.   
        x = wholeAndPositive('x')
        
        #Asks for input and makes sure it is positive and an integer.
        y = wholeAndPositive('y')
        
        print(x, " ^ ", y, " = " , exp(x,y))
            

    elif ask == '4':

        #Asks for input and checks it is positive.
        x = positive('x')
        #Asks for input and checks it is positive.
        y = positive('y')
        
        #if you use a decimal number here there may be a small negligable rounding error due to the way python rounds.
        print(x, " mod ", y, " = " , modulo(x,y))
        

    else:
        print("This is is not an option. Please enter one of the options shown in the menu below. ")
        
print(''' 
Thank you for using our services today. 
''')
