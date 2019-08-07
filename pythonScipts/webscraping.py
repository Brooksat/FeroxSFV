from bs4 import BeautifulSoup
from bs4 import Comment
from bs4 import NavigableString
from selenium import webdriver
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.by import By
import csv
import os
import time

#Close anything that hasnt been closed
def closeDangling():
    os.system("taskkill /f /im geckodriver.exe /T")
    os.system("taskkill /f /im chromedriver.exe /T")
    #os.system("taskkill /f /im IEDriverServer.exe /T")

def removeCommentsAndAttributes(element):
    for e in element.find_all(True):
        e.attrs = {}
    for el in element(text=lambda text: isinstance(text, Comment)):
        el.extract()
    

def removeTaunt(moveList):
    
    for row in moveList:
        
        moveName = row.find(['td','th'])
        
        if(moveName.get_text().strip() == "Taunt"):
            moveList.remove(row)

#sets character data on page
def openCharData(character):
    ##set names to common
    #names button
    driver.find_element_by_xpath('/html/body/div/div/nav/div/div[2]/ul[1]/li[3]/a').click() 
    #common names button
    driver.find_element_by_xpath('//*[@id="frameDataView"]/nav/div/div[2]/ul[1]/li[3]/ul/li[4]/a').click() 
    #select character from list
    driver.find_element_by_class_name('selected-player').click()
    
    #wait for list of characters
    try:
        charMenu = WebDriverWait(driver,10).until(EC.presence_of_element_located((By.XPATH, '//*[@id="frameDataView"]/nav/div/div[2]/ul[2]/li/ul')))
    except TimeoutError:
        print("Too slow")
    
    charMenu.find_element_by_link_text(character).click()
    #time.sleep(1)
    # #wait until page has updated with new char data
    # try:
    #     charMenu = WebDriverWait(driver,10).until(EC.text_to_be_present_in_element((By.CLASS_NAME, 'selected-player'),character))
    # except TimeoutError:
    #     print("Too slow")

    print("The currently selected character is " + driver.find_element_by_class_name('selected-player').text)
    
    soup = BeautifulSoup(driver.page_source, "html.parser")
    frameDataTable = soup.select('#frameDataTable')
    #get rid of comments, attributes
    removeCommentsAndAttributes(frameDataTable[0])
    

    rows = frameDataTable[0].find_all("tr")
    removeTaunt(rows)

    ### set namesto official
    #names button
    driver.find_element_by_xpath('/html/body/div/div/nav/div/div[2]/ul[1]/li[3]/a').click() 
    
    #official names button
    driver.find_element_by_xpath('//*[@id="frameDataView"]/nav/div/div[2]/ul[1]/li[3]/ul/li[3]/a').click() 
    
    soup = BeautifulSoup(driver.page_source, "html.parser")
    frameDataTable = soup.select('#frameDataTable')
    #get rid of comments, attributes
    removeCommentsAndAttributes(frameDataTable[0])
    

    rowsOfficial = frameDataTable[0].find_all("tr")
    removeTaunt(rowsOfficial)

    
    writeFrameDataTable(character, rows, rowsOfficial)
    

    #soup = BeautifulSoup(driver.page_source, "html.parser")

#writes frameData to table
def writeFrameDataTable(character, rows, rowsOfficial):
    fileName = character + '.csv'

    csv_file = open(fileName, 'w+',newline='')
    writer = csv.writer(csv_file)
    try:
        for row, rowO in zip(rows,rowsOfficial):
            #print(row)
            csvRow = []
            cellO = rowO.find(['td','th'])
            csvRow.append(cellO.get_text().strip())
            for cell in row.find_all(['td','th']):
                
                csvRow.append(cell.get_text().strip())
            
            writer.writerow(csvRow)
    finally:
        csv_file.close

closeDangling()

url = 'https://fullmeter.com/fatonline/#/framedata/Abigail'
driver = webdriver.Chrome()
driver.get(url)
soup = BeautifulSoup(driver.page_source, "html.parser")


try:
    WebDriverWait(driver,10).until(EC.presence_of_element_located((By.CLASS_NAME, 'selected-player')))
except TimeoutError:
    print("Too slow")

listButton = driver.find_element_by_class_name('selected-player')
listButton.click()

#wait for list of characters
try:
    WebDriverWait(driver,10).until(EC.presence_of_element_located((By.XPATH, '//*[@id="frameDataView"]/nav/div/div[2]/ul[2]/li/ul')))
except TimeoutError:
    print("Too slow")

soup = BeautifulSoup(driver.page_source, "html.parser")


charList = soup.find("ul",class_="dropdown-menu scrollable").find_all("a")
nameArr = []
for aName in charList:
     nameArr.append(aName.text)
removeCommentsAndAttributes(charList[0])
listButton.click()

for name in nameArr:
    openCharData(name)







    



# wait for framedata table
# try:
#     element = WebDriverWait(driver,20).until(EC.presence_of_element_located((By.ID,'frameDataView')))
# except TimeoutError:
#     print("Too slow")



# takes in bs4 tag
# def removeWhiteSpace(param):
#     if param.string is not None:
#         param.string.replace('\r\n', '')
#         print(param)
#     else:
#         for paramChild in param.find_all(True):
#             print("---recursive call start---")
#             removeWhiteSpace(paramChild)
#             print("---recursive call return---")











        

#print(frameDataTable)


#driver.quit()




