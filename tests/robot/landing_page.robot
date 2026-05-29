*** Settings ***
Documentation     Skenario Pengujian Landing Page Aplikasi Path Deck
Library           SeleniumLibrary

*** Variables ***
${URL}            http://127.0.0.1:8000
${BROWSER}        chrome

*** Test Cases ***
Validasi Elemen Navbar Landing Page
    [Documentation]    Memastikan komponen navigasi utama muncul dan sesuai desain
    Open Browser    ${URL}    ${BROWSER}
    Maximize Browser Window
    Page Should Contain    Path Deck
    Page Should Contain    Dashboard
    Page Should Contain    Explore path
    Page Should Contain    Login
    Page Should Contain Link    xpath=//a[contains(text(), 'Register')]