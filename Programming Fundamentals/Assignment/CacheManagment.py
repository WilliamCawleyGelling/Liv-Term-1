#William Cawley Gelling 
#CA3 - Cache Management 

#empty cashe list set as a global veriable 
cache = []

#empty requests list set as a global variable 
requests = [] 

#First lets have a function that asks for ints repetidley until 0 is entered
def request (): 
    while True: 

        try: 
            a = int(input("Please input an integer to be requested, enter 0 to finish: "))
            if a == 0: 
                break
            else: 
                requests.append(a)

        #Gives exeption for any Errors 
        except : 
            print("Oops! Please input a valid integer. Try again ...")

def fifo() : 

    for i in requests: 

        if i in cache: 
            print(i,"is a hit")

        elif len(cache) < 8: 
            print(i, "is a miss")
            cache.insert(0, i)
        else :
            print(i, "is a miss")
            cache.pop() 
            cache.insert(0,i)
    
    print("The cashe contains: ", cache)

#only rembers those in the case and forgets when they leave
#this takes out the most reasent one 
def lfu(): 
    hit = False 
    for i in requests: 
        
        hit = False 

        for j in range(len(cache)): 
            if cache[j][0] == i: 
                cache[j][1] = cache[j][1] + 1
                print(i, "is a hit") 
                hit = True
                break 
        
        if hit == False and len(cache) < 8: 
            print(i, "is a miss")
            cache.append([i,1])

        elif hit == False: 
            print(i, "is a miss")
            cache.sort(reverse = True)
            cache.sort(key = lambda x : x[1], reverse = True) 
            cache.pop()
            cache.append([i,1])
                
    print("The cashe contains: ", cache)


print("Welcome to the cache requst sysetem") 

while True: 

    request() 

    print("""There are two sorting options for the cache and a quit option : 
    1) First in First out. 
    2) Least Frequently Used. 
    q) Quit. 
    """)
    while True: 
        ask = input("Please enter 1, 2, q: ")
        if  ask == "q" or ask == "Q" or ask == "1" or ask == "2": 
            break 
        else: 
            print("Invalid input please try again.")
    
    if ask == "q" or ask == "Q": 
        break
    elif ask == "1": 
        fifo()
    elif ask == "2": 
        lfu()

    cache.clear() 
    requests.clear() 

print("Thank you for using my programm")

    
