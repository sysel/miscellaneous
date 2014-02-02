SET PATH=%PATH%;%windir%\Microsoft.NET\Framework\v4.0.30319

csc /r:System.Windows.Forms.dll TestApp.cs HelloMsg.cs

csc @TestAppResponse.rsp

rem parameters after rsp file overwrites ones defined in rsp file
rem csc @TestAppResponse.rsp /out:AnotherDummyApp.exe
