using System;
using System.Windows.Forms;

class TestApp
{
    static void Main()
    {
        Console.WriteLine("Hello world!");
        
        HelloMessage h = new HelloMessage();
        h.Speak();
    }
}
