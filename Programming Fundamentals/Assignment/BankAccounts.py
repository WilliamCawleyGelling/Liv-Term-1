''' 
William Cawley Gelling 
201077658
Assignment 4 Bank Accounts
'''

from random import randint
import datetime


class BasicAccount(): 
    '''
    Basic account is the account to be used for individules for the company/Bank 
    ''' 
    #incremented when a bank account is made.
    noOfAc = 0

    #List of card numbers that have already been used.
    cardNoList = []


    @classmethod 
    def makeCardNum(cls):

        """
        Creates a card number and checks that it does not already exist, 
        if it does it creates a new card number and checks untill it has an unused number.

        Parameters:
            Nothing
        Returns:
            returns the string of the card number 
        """
        while True: 
            a = ""
            for x in range (0,16):
                a += str(randint(0,9))
            
            if a in cls.cardNoList: 
                continue 
            else : 
                return a

    @classmethod
    def checkStartBalance(cls,theBalance):
        """
        to be used during __init__ 
        checks that the start balance is a valid balance, keeps asking until balance of correct form
        is entered.
        This is designed so only floats are excepted e.g. 50.0 is excepted but 50 is not.

        Parameters:
            theBalance - this is the balance entered when creating an instance 
        Returns:
            theBalance - this is the balance entered that fullfils the critiria 
        """
        while True:
            if isinstance(theBalance,float) == True:
                if theBalance >= 0: 
                    return theBalance 
                    
                else: 
                    try: 
                        theBalance= float(input("theBalance has to be positive or zero, please enter again: "))
                    except: 
                        print("please enter a positive/zero float: ")
            else:
                try: 
                    theBalance = float(input("theBalance has to be a positve/zero float. please input again:  "))
                except: 
                    print("please enter a positive/zero float: ")

    @classmethod
    def checkStartName(cls, theName):
        """
        to be used during __init__ 
        checks that the start name is a valid name, i have defined this 
        as being a string that starts with a letter

        Parameters:
            theName - this is the name entered when creating an instance 
        Returns:
            theBalance - this is the name entered of the correct form 
        """
        while True:
            if isinstance(theName,str):
                if theName[0].isalpha(): 
                    return theName
                    break 
                else : 
                    theName = input("The name has to start with a letter, please input theName again: ")
            else: 
                theName = input("The name has to start with a letter, please input theName again: ")



    
    def __init__(self, theName, theBalance = 0.0) : 

        self.name = self.checkStartName(theName)
        self.balance = self.checkStartBalance(theBalance)
        BasicAccount.noOfAc += 1
        self.acNum = BasicAccount.noOfAc
        self.cardNum = self.makeCardNum()
        self.joinDate = datetime.datetime.now()
        self.cardExp = (self.joinDate.month , self.joinDate.year - 1997)

    def __str__(self):
        return '\nYour account name is: ' + self.name +'\nYour balance is : ' + "£{:,.2f}".format(self.balance) + '\n'

    def getAvailableBalance(self): 
        """
        Calculates and returns the total balance available and returns as a float 

        Parameters:
            Nothing
        Returns:
            The total available balance available as a float 
        """
        return float(self.balance)

    def getBalance(self): 
        """
        returns the balance available as a float 

        Parameters:
            Nothing
        Returns:
            The balance as a float 
        """
        return float(self.balance)

    def printBalance(self):
        """
        Prints the Balance available

        Parameters:
            None
        Returns:
            Nothing
        """
        print('Your balance is: ' + "£{:,.2f}".format(self.balance))

    def getName(self):
        """
        Returns the name of the account holder

        Parameters:
            None
        Returns:
            Name of the account holder as a string 
        """

        return str(self.name)

    def getAcNum(self):
        """
        Returns the account number as a string 

        Parameters:
            None
        Returns:
            account number as a sting 
        """
        return str(self.acNum)

    def issueNewCard(self):
        """
        Creates a new card with new number and expiry date.

        Parameters:
            None
        Returns:
            nothing
        """
        self.cardNum = self.makeCardNum()
        today = datetime.datetime.now()
        self.cardExp = (today.month , today.year - 1997)
        



    def deposit(self,deposits): 
        """
        Deposits the stated amount into the account and adjusts the balance appropriately.
        Deposits must be a positive amount.

        Parameters:
            deposit: the amount that they wish to deposit

        return:
            Nothing 
        """
        if isinstance(deposits, float) or isinstance(deposits, int):
            if deposits <= 0: 
                print ("Deposit not possible, You can only add a positive nonzero ammount to your account.")
            else: 
                self.printBalance()
                print ('You are depositing: '+ "£{:,.2f}".format(self.balance))
                self.balance += deposits
                self.printBalance()
        else: 
            print('Deposit not avalible, You need to enter a float')

    def withdraw(self, withdraws): 
        """
        Withdraws the stated amount from the account and prints information about the withdrawral. 
        If an invalid amount is requested, then a warning message appears and the process is terminated 

        Parameters:
            withdraws: the amount that they wish to withdraw

        return:
            Nothing
        """

        try:   
            if isinstance(withdraws, float) == False: 
                raise TypeError ("\nYour withdrawral has to be od type float")
            if withdraws > self.getAvailableBalance(): 
                raise ValueError ("\nYour withdrawral can not be larger then your balance.")
            elif withdraws < 0 : 
                raise ValueError ("\nYour withdrawral can not be negative")
            self.balance -= withdraws
            print(self.name, "has withdrawn "+ '£{:,.2f}'.format(withdraws))
            self.printBalance()

        except Exception as exp: 
                print("Can not Withdraw "+ '£{:,.2f}'.format(withdraws).replace('£-','-£'), exp)

    def closeAccount(self): 
        """
        to be called before deleting of the object instence, Returns remaining balence to the customer
        and then returns True. If the person has a negative balance then account will not be able 
        to close and a message will show. False will be returned

        Parameters:
            None

        return:
            retuns TRUE OR FALSE depending on whether it is successful 
        """
        if self.balance >= 0: 
            self.withdraw(self.balance)
            return True 
        else :
            print("Can not close account due to customer being overdrawn by £", abs(self.balance))
            return False 


class PremiumAccount(BasicAccount): 

    '''
    Premium account is a basic account with the addition of an overdraft 
    '''

    @classmethod 
    def checkStartOverdraft(cls,theOverdraftLimit): 
        """
        to be used during __init__ 
        checks that the start overdraft limit is a valid, keeps asking until limit of correct form
        is entered.
        This is designed so only floats are excepted e.g. 50.0 is excepted but 50 is not. 
        
        Parameters:
            theOverdraftLimit - this is the overdraft limit entered when creating an instance 
        Returns:
            theBalance - this is the overdraft limit entered that fullfils the critiria 
        """

        while True:
            if isinstance(theOverdraftLimit,float) == True:
                if theOverdraftLimit >= 0: 
                    return theOverdraftLimit
                    
                else: 
                    try: 
                        theOverdraftLimit= float(input("theOverdraftLimit has to be positive or zero, please enter again: "))
                    except: 
                        print("please enter a positive/zero float: ")
            else:
                try: 
                    theOverdraftLimit = float(input("theOverdraftLimit has to be a positve/zero float. please input again:  "))
                except: 
                    print("please enter a positive/zero float: ")





    def __init__(self, theName, theBalance = 0.0, theOverdraftLimit = 0.0): 
        super().__init__(theName, theBalance)
        self.overdraftLimit = self.checkStartOverdraft(theOverdraftLimit)
        self.overdraft = True
        
    def __str__(self):
        return '\nYour account name is: ' + self.name + self.printedBalance() 

    def setOverdraftLimit(self, newLimit):

        """
        resets the overdraft limit, checks that this allowed by checking that it is a positive or zero 
        float. If the person is already in there overdraft it makes sure that the new limit is grater or equal 
        to the absolute value of their balance
        
        Parameters:
            newlimit - the new overdraft to be used, needs to be a float 
        Returns:
            none 
            
        """ 
        if self.overdraft == True:
            newLimit = self.checkStartOverdraft(newLimit) 
            if self.balance < 0: 
                if newLimit >= abs(self.balance):
                    self.overdraftLimit = newLimit
                else: 
                    print("To much money is owed to be able to change the overdraft limit to this")
            else: 
                self.overdraftLimit = newLimit 
        else: 
            print("Your account does not support overdrafts")


        

    def getAvailableBalance(self):
        """
        Calculates and returns the total balance available and returns as a float 

        Parameters:
            Nothing
        Returns:
            The total availble balance availble as a float 
        """
        return self.balance + self.overdraftLimit


    def printedBalance(self): 
        """
        makes the information to be printed in printBalance in a single string to be easily used in 
        __str__ as well.

        Parameters:
            None
        Returns:
            x - the sting formation of the balance and overdarft information
        """


        x = '\nYour balance is: ' + "£{:,.2f}".format(self.balance).replace('£-','-£')
        if self.overdraft == True:
            x +=  '\nYour avalible balance is:'+ "£{:,.2f}".format(self.getAvailableBalance()).replace('£-','-£')
            x +=  '\nYour overdraft is '"£{:,.2f}".format(self.overdraftLimit).replace('£-','-£')
            if self.balance < 0 : 
                x += '\nYour remaining overdraft is '"£{:,.2f}".format(self.overdraftLimit+self.balance).replace('£-','-£')
            else: 
                x += '\nYour remaining overdraft is '"£{:,.2f}".format(self.overdraftLimit).replace('£-','-£')
        return x

    
    def printBalance(self):
        """
        Prints the Balance avalible, as well as the overdraft availble 

        Parameters:
            None
        Returns:
            Nothing
        """
        print(self.printedBalance())

    #I have not redone closeAccount as this issue was covered for both in the super class (BasicAccount)
