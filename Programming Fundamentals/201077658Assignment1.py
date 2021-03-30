#William Cawley Gelling 
#Student NO 201077658

#This is the function used to calculate the remaining interior angle 
def intAngle():

    #Asking for interior angles a and b, testing for exceptions
    #Using a as variable for first angle
    #Using b as variable for second angle 
    while True: 
        try: 
            a = float(input("Please input first interior angle in degrees."))
            #Checking that the angles fulfuil the criteria for angles in a triangle.
            if 0 < a <180: 
                break
            elif a < 0: 
                print("Please input positive angles only. Try again ...")
            elif a == 0: 
                print("Please input a non zero angle. Try again ...")
            else: 
                print("A triangle can not have a angle of 180 degrees or greater. Try again... ")
        #Gives exeption for any Errors 
        except : 
            print("Oops! Please input a valid number. Try again ...")
        
    while True: 
        try: 
            b = float(input("Please input second interior angle in degrees."))
            #Checking that the angles fulfuil the criteria for angles in a triangle.
            if 0 < b <180: 
                break
            elif b < 0: 
                print("Please input positive angles only. Try again ...")
            elif b == 0: 
                print("Please input a non zero angle. Try again ...")
            else: 
                print("A triangle can not have a angle of 180 degrees or greater. Try again... ")
        #Gives exeption for any Errors 
        except : 
            print("Oops! Please input a valid number. Try again ...")

    #Calculating the interior angle
    if 0 < a+b < 180: 
        #excluding angles that do not create a triangle. 
        ans = 180 - a - b 
        print("The first angle is ", a, "degrees. \nThe second angle is ", b, "degrees. \nThe final angle is ", ans, "degrees. \nYou will now be taken back to the main menu.")

    else:
        print("Interior angles add to 180 or over, therefore cannot be a triangle. \nYou will now be taken back to the main menu.")

#This is the function used to calculate the length of the hypotenuse in a right angle triangle. 
def length(): 
    #Asking for the two non hypotenuse lengths 
    #Using A as variable for first length
    #Using B as variable for the second length 
    while True: 
        try: 
            A = float(input("Please insert first length in cm."))
            #Checking that the length is positve and non zero. 
            if A > 0:
                break
            elif A < 0: 
                print("Please input positive length only. Try again ...")
            elif A == 0: 
                print("Please input a non zero length. Try again ...")

        #Gives exeption for any Errors 
        except : 
            print("Oops! Please input a valid number. Try again ...")

    while True: 
        try: 
            B = float(input("Please insert second length in cm."))
            #Checking that the length is positve and non zero. 
            if B > 0:
                break
            elif B < 0: 
                print("Please input positive length only. Try again ...")
            elif B == 0: 
                print("Please input a non zero length. Try again ...")

        #Gives exeption for any Errors 
        except : 
            print("Oops! Please input a valid number. Try again ...")


    C = (A**2+B**2)**(1/2) 
    print("The first length is ", A, "cm. \nThe second length is ", B, "cm. \nThe length of the hypotenuse is ", C, "cm. \nYou will now be taken back to the main menu.")

#This is the function used to calculate the area of a triangle. 
def area(): 
    #Asking for the three lengths of the triangle.
    #Using A as variable for the first length.
    #Using B as variable for the second length. 
    #Using C as variable for the third length.

    while True: 
        try: 
            A = float(input("Please insert first length in cm."))
            #Checking that the length is positve and non zero. 
            if A > 0:
                break
            elif A < 0: 
                print("Please input positive length only. Try again ...")
            elif A == 0: 
                print("Please input a non zero length. Try again ...")

        #Gives exeption for any Errors 
        except : 
            print("Oops! Please input a valid number. Try again ...")
    
    while True: 
        try: 
            B = float(input("Please insert first length in cm."))
            #Checking that the length is positve and non zero. 
            if B > 0:
                break
            elif B < 0: 
                print("Please input positive length only. Try again ...")
            elif B == 0: 
                print("Please input a non zero length. Try again ...")

        #Gives exeption for any Errors 
        except : 
            print("Oops! Please input a valid number. Try again ...")

    while True: 
        try: 
            C = float(input("Please insert first length in cm."))
            #Checking that the length is positve and non zero. 
            if C > 0:
                break
            elif C < 0: 
                print("Please input positive length only. Try again ...")
            elif C == 0: 
                print("Please input a non zero length. Try again ...")

        #Gives exeption for any Errors 
        except : 
            print("Oops! Please input a valid number. Try again ...")
    #Calculation for the semi-perimeter of the triangle 
    s = (A + B + C)/2        
    #Use of herons formula 
    d = (s*(s-A)*(s-B)*(s-C))**(1/2)     
    try: 
        if d > 0:
            print("The first length is ", A, "cm. \nThe second length is ", B, "cm. \nThe third length is ", C ,"cm. \nThe area of the triangle is ", d , "cm squared. \nYou will now be taken back to the main menu")
        else: 
            print("These lengths do not make a triangle, You will now be taken back to the main menu") 
    #This deals with errors that come up for situations where the answer d is complex (imaginary)
    except TypeError:
        print("These lengths do not make a triangle, You will now be taken back to the main menu")

#Now start the program 
print(' '*10 + "Welcome to triangles R us! \nThe one stop place for all your triganomical needs. ")

#This while loop will run until q is selected at the main menue
while True: 
    #Info for the main menu 
    print("We have three options to help you with today: \n1:   Calculating the missing angle. Enter your angles (in degrees not radians) and we will produce your missing angle in degrees. \n2:   Length of hypotenuse in a right angle triangle. Enter your 2 lengths (cm) and your hypotenuse length will be returned. \n3:   Area of a triangle. Provide us with the three lengths (cm) of the triangle and your area will be returned (cm squared). \nPress q to quit." )

    #This asks for the input and runs the functions until q is pressed, using quest for question as variable 
    quest = input("Please enter '1','2','3' or 'q' depending on the serivce you require.")
    if quest == '1':
        intAngle()
    elif quest == '2': 
        length()
    elif quest == '3': 
        area()
    elif quest == 'q':
        break
    else: 
        print("This is not an option. Try again ...")

print("Thank you for using Triangles R us. Please think of us for your next triganomical needs.")