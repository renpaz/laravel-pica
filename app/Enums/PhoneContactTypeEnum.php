<?php
namespace App\Enums;

class PhoneContactTypeEnum extends Enum
{
    const DEFAULT = 'Irrelevante';
    const CALL_ONLY = 'Apenas Ligações';
    const SMS_ONLY = 'Apenas SMS';
    const WHATSAPP_ONLY = 'Apenas WhatsApp';
    const MESSAGES = 'Mensagens no Geral';
    const MESSAGES_AND_WHATSAPP_CALLS = 'Mensagens e Ligações no WhatsApp';
}
