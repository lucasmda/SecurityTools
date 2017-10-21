#!/usr/bin/python

import smtplib

mail_server = smtplib.SMTP("relay.sp.t-systems.com.br", 25)
mail_server.ehlo()
mail_server.starttls
mail_Server.ehlo()

mail_server.sendmail("T-SystemsBrazilCERT@t-systems.com.br", "abner.almeida@t-systems.com.br", "No presence of DOUBLEPULSAR SMB implant on IP bla.bla.bla.bla")