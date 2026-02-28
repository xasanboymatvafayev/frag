<?php
ob_start();

define("API_KEY","8233780541:AAHV0ZH67NWoluF49RPpj6BuWgmbSWjEIOk"); // Botingizni tokenini yozasiz
$admin = "6365371142"; // Telegram ID raqamingizni kiritasiz
$apiKey = "kNDru8SaJwf"; // Api kalitni @ArzonStarsBot dan olib ulaysizlar!!!
$foiz = "9"; // Stars ustiga qo'yiladigan foizni kiritasiz


/*
@Stars_APIBot kodi!

Manba: @Org_Coder (Chopmanglar ancha mehnat ketgan)
Tarqatildi: @TexnoPHPuz kanalida
*/


//Shu joy orqali tovo tizimlarini qo'shasiz
$tizimlar = json_encode([
	'inline_keyboard'=>[
	[['text'=>"🔰 UzCard",'callback_data'=>"tizim—🔰 UzCard—5614683582279246"]],
	]]);
	

function bot($data,$method=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$data;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$method);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}

$update = json_decode(file_get_contents("php://input"));
$message = $update->message;
$text = $message->text;
$cid = $message->chat->id;
$mid = $message->message_id;
$photo = $message->photo;
$data = $update->callback_query->data;
$qid = $update->callback_query->id;
$cid2 = $update->callback_query->message->chat->id;
$mid2 = $update->callback_query->message->message_id;
$qid = $update->callback_query->id;
$step = file_get_contents("step/$cid.txt");
$balance = file_get_contents("users/$cid/balance.txt");
$kiritgan = file_get_contents("users/$cid/kiritgan.txt");

if(!file_exists("step")){
    mkdir("step", 0777, true);
}
if(!file_exists("users")){
    mkdir("users", 0777, true);
}
if(!file_exists("users/$cid")){
    mkdir("users/$cid", 0777, true);
}

if(isset($message)){
	if($balance == null or $kiritgan == null){
		file_put_contents("users/$cid/balance.txt","0");
		file_put_contents("users/$cid/kiritgan.txt","0");
		} else {
			}
			}
			
$back = json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"⏮️ Orqaga"]],
]]);

if($text == "/start" or $text == "⏮️ Orqaga"){
	bot('sendMessage',[
	'chat_id'=>$cid,
	'text'=>"<b>🛒 Ushbu bot yordamida telegram starslarni avtomatik tarzda sotib olishingiz mumkin ✅</b>",
	'parse_mode'=>'html',
	'reply_markup'=>json_encode([
	'resize_keyboard'=>true,
	'keyboard'=>[
	[['text'=>"🌟 Stars olish"]],
	[['text'=>"💵 Hisobim"],['text'=>"📥 Hisobni to'ldirish"]],
	]])
	]);
	unlink("step/$cid.txt");
	exit();
	}
	
//Eng asosiy joyi

if($text == "🌟 Stars olish"){
	bot('sendMessage',[
	'chat_id'=>$cid,
	'text'=>"<b>📑 Sotib olmoqchi bo'lgan stars miqdorini yuboring:</b>
<i>⚠️ Minimal: 50</i>",
	'parse_mode'=>'html',
	'reply_markup'=>$back
	]);
	file_put_contents("step/$cid.txt","miqor");
	}
	
if($step == "miqor"){
if(is_numeric($text)){
if($text >= 50){
	bot('sendMessage',[
	'chat_id'=>$cid,
	'text'=>"<b>👤 Kimga yubormoqchisiz ❓
🔗 Usernameni yuboring yoki o'zingizga olmoqchi bo'lsangiz o'zingizni userigizni yuboring ✅</b>

<blockquote>📋 Na'muna: @Org_Coder</blockquote>",
	'parse_mode'=>'html',
	'reply_markup'=>$back
	]);
	file_put_contents("step/$cid.txt","username-$text");
	exit();
	} else {
		bot('sendMessage',[
		'chat_id'=>$cid,
		'text'=>"<b>‼️ Minimal 50 ta stars!</b>",
		'parse_mode'=>'html',
		]);
		}
	} else {
		bot('sendMessage',[
		'chat_id'=>$cid,
		'text'=>"<b>🔢 Faqat raqamlardan foydalaning!</b>",
		'parse_mode'=>'html',
		]);
		}
	}
	
/*
@Stars_APIBot kodi!

Manba: @Org_Coder (Chopmanglar ancha mehnat ketgan)
Tarqatildi: @TexnoPHPuz kanalida
*/
	
if(mb_stripos($step, "username-") !== false){
if(mb_stripos($text, "@") !== false){
	$ex = explode("-",$step);
	$stars = $ex[1];
	$json = json_decode(file_get_contents("https://arzonstars.uz/api?key=$apiKey&action=get_price"), true);
	$birstar = $json['stars_price'];
	$jami = $stars * $birstar;
	$bol=$jami/100;
    $aniq = $bol * $foiz + $jami;
	bot('sendMessage',[
	'chat_id'=>$cid,
	'text'=>"<b>☑️ Qabul qilindi 👇</b>

<blockquote><b>🌟 Stars miqdori:</b> <u>$stars</u>
<b>👤 Username:</b> $text
<b>💰 Hisoblangan narx:</b> <u>$aniq so'm</u></blockquote>

<b>❗️ Agar stars narxi sizga ma'qul kelgan bo'lsa pastdagi «</b>🛒 Sotib olish<b>» tugmasini usiga bosing ✅</b>",
	'parse_mode'=>'html',
	'reply_markup'=>json_encode([
	'inline_keyboard'=>[
	[['text'=>"🛒 Sotib olish",'callback_data'=>"stb-$stars-$text-$aniq"]],
	]])
	]);
	unlink("step/$cid.txt");
	exit();
	} else {
		bot('sendMessage',[
		'chat_id'=>$cid,
		'text'=>"<b>⚠️ Usernameni na'munadagidek qilib yuboring!</b>
<blockquote>📋 Na'muna: @Org_Coder</blockquote>",
		'parse_mode'=>'html',
		]);
		}
	}
	
if(mb_stripos($data, "stb-") !== false){
	$ex = explode("-", $data);
	$stars = $ex[1];
	$user = $ex[2];
	$jami = $ex[3];
	$yetma = $jami - $balance;
	$username = str_replace("@", "", $user);
	$json = json_decode(file_get_contents("https://arzonstars.uz/api?key=$apiKey&action=buy_stars&username=$username&stars=$stars"), true);
	$mess = $json['message'];
	$status = $json['success'];
	$balance = file_get_contents("users/$cid2/balance.txt");
if($balance >= $jami){
if($status == true){
	$org = $balance - $jami;
	file_put_contents("users/$cid2/balance.txt","$org");
    bot('deleteMessage',[
	'chat_id'=>$cid2,
	'message_id'=>$mid2,
	]);
	bot('sendMessage',[
	'chat_id'=>$cid2,
	'text'=>"✅ <b>$mess</b>",
	'parse_mode'=>'html',
	]);
	} else {
		bot('deleteMessage',[
		'chat_id'=>$cid2,
		'message_id'=>$mid2,
		]);
		bot('sendMessage',[
		'chat_id'=>$cid2,
		'text'=>"<b>‼️ Xatolik yuz berdi!</b>",
		'parse_mode'=>'html',
		]);
		}
	} else {
		bot('deleteMessage',[
		'chat_id'=>$cid2,
		'message_id'=>$mid2,
		]);
		bot('sendMessage',[
		'chat_id'=>$cid2,
		'text'=>"<b>⛔️ Hisobingizda yetarli mablag' mavjud emas!</b>
<i>💰 Sizga yana $yetma so'm yetishmayapti</i>",
		'parse_mode'=>'html',
		'reply_markup'=>$back
		]);
		}
	}
	
/*
@Stars_APIBot kodi!

Manba: @Org_Coder (Chopmanglar ancha mehnat ketgan)
Tarqatildi: @TexnoPHPuz kanalida
*/
	
//Hisob joyi
	
if($text == "💵 Hisobim"){
	bot('sendMessage',[
	'chat_id'=>$cid,
	'text'=>"<b>🆔 ID raqamingiz:</b> <code>$cid</code>
<b>💰 Hisobingiz:</b> $balance so'm
<b>💳 Pul kiritganlaringiz:</b> $kiritgan so'm",
	'parse_mode'=>'html',
	]);
	}
	
if($text == "📥 Hisobni to'ldirish"){
	bot('sendMessage',[
	'chat_id'=>$cid,
	'text'=>"<b>💳 Quyidagi to'lov tizimlaridan birini tanlang:</b>",
	'parse_mode'=>'html',
	'reply_markup'=>$tizimlar
	]);
	}
	
if(mb_stripos($data, "tizim—") !== false){
	$ex = explode("—", $data);
	$tizim = $ex[1];
	$karta = $ex[2];
	bot('deleteMessage',[
	'chat_id'=>$cid2,
	'message_id'=>$mid2,
	]);
	bot('sendMessage',[
	'chat_id'=>$cid2,
	'text'=>"<b>📱 To'lov tizimi:</b> <u>$tizim</u>
<b>💳 Karta raqami:</b> <code>$karta</code>

<blockquote><i>⏳ Ushbu kartani nusxalab bank ilovalariga kirib o'zingizga kerakli summani tashlab pastdagi</i> «<b>✅ Tashladim</b>» <i>tugmasini ustiga bosing 👇</i></blockquote>",
	'parse_mode'=>'html',
	'reply_markup'=>json_encode([
	'inline_keyboard'=>[
	[['text'=>"✅ Tashladim",'callback_data'=>"tash-$tizim"]],
	]])
	]);
	}
	
if(mb_stripos($data, "tash-") !== false){
	$ex = explode("-", $data);
	$tizim = $ex[1];
	bot('deleteMessage',[
	'chat_id'=>$cid2,
	'message_id'=>$mid2,
	]);
	bot('sendMessage',[
	'chat_id'=>$cid2,
	'text'=>"<b>⁉️ Kartaga qancha summa tashlaganingizni yuboring:</b>",
	'parse_mode'=>'html',
	'reply_markup'=>$back
	]);
	file_put_contents("step/$cid2.txt","summa-$tizim");
	}
	
if(mb_stripos($step, "summa-") !== false){
	$ex = explode("-", $step);
	$tizim = $ex[1];
if(is_numeric($text)){
if($text >= 1000){
	bot('sendMessage',[
	'chat_id'=>$cid,
	'text'=>"<b>🖼 Endi shu kartaga pul tashlaganingiz haqidagi chek rasmini yuboring:</b>",
	'parse_mode'=>'html',
	'reply_markup'=>$back
	]);
	file_put_contents("step/$cid.txt","chek-$tizim-$text");
	exit();
	} else {
		bot('sendMessage',[
		'chat_id'=>$cid,
		'text'=>"<b>‼️ Minimal pul kiritish miqdori: 1000 so'm</b>",
		'parse_mode'=>'html',
		'reply_markup'=>$back
		]);
		}
		} else {
			bot('sendMessage',[
		'chat_id'=>$cid,
		'text'=>"<b>⚠️ Faqat raqamlardan foydalaning!</b>",
		'parse_mode'=>'html',
		'reply_markup'=>$back
		]);
		}
	}
	
	// 💰💰💸💸
/*
@Stars_APIBot kodi!

Manba: @Org_Coder (Chopmanglar ancha mehnat ketgan)
Tarqatildi: @TexnoPHPuz kanalida
*/
	
if(mb_stripos($step, "chek-") !== false){
	$ex = explode("-", $step);
	$tizim = $ex[1];
	$summa = $ex[2];
	$photo = $message->photo;
    $fileid = $photo[count($photo)-1]->file_id;
if(isset($photo)){
    bot('sendMessage',[
    'chat_id'=>$cid,
    'text'=>"<b>✅ So'rovingiz administratorlarga yuborildi!</b>",
    'parse_mode'=>'html',
    ]);
    bot('sendPhoto',[
    'chat_id'=>$admin,
    'photo'=>$fileid,
    'caption'=>"<b>⌛ Hisob to'ldirish bo'yicha so'rov!</b>

<blockquote>💳 To'lov tizimi: <u>$tizim</u>
<b>💸 To'ldirmoqchi bo'lgan summa:</b> $summa so'm
<b>🆔 Foydalanuvchi ID raqami:</b> $cid
<b>💰 Hisobi:</b> $balance so'm</blockquote>", // togri yopilgan
    'parse_mode'=>'html',
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
    [['text'=>"✅ Tastiqlash",'callback_data'=>"tas-$cid-$summa"]],
    [['text'=>"❌ Bekor qilish",'callback_data'=>"bekor-$cid-$summa"]],
    ]])
    ]);
    unlink("step/$cid.txt");
    exit();
    } else {
    	bot('sendMessage',[
    'chat_id'=>$cid,
    'text'=>"<b>‼️ Faqat rasm ko'rinishida qabul qilinadi!</b>",
    'parse_mode'=>'html',
    ]);
    }
	}
	
if(mb_stripos($data, "tas-") !== false){
	$ex = explode("-", $data);
	$user_id = $ex[1];
	$summa = $ex[2];
	$balance = file_get_contents("users/$user_id/balance.txt");
	$org = $balance + $summa;
	file_put_contents("users/$user_id/balance.txt","$org");
	$kiritgan = file_get_contents("users/$user_id/kiritgan.txt");
	$kir = $kiritgan + $summa;
	file_put_contents("users/$user_id/kiritgan.txt","$kir");
	bot('deleteMessage',[
	'chat_id'=>$cid2,
	'message_id'=>$mid2,
	]);
	bot('sendMessage',[
	'chat_id'=>$cid2,
	'text'=>"<b>✅ Tastiqlandi!</b>",
	'parse_mode'=>'html',
	]);
	bot('sendMessage',[
	'chat_id'=>$user_id,
	'text'=>"<b>➕ Hisobingizga +$summa so'm qo'shildi!</b>",
	'parse_mode'=>'html',
	]);
	}
	
if(mb_stripos($data, "bekor-") !== false){
	$ex = explode("-", $data);
	$user_id = $ex[1];
	$summa = $ex[2];
	bot('deleteMessage',[
	'chat_id'=>$cid2,
	'message_id'=>$mid2,
	]);
	bot('sendMessage',[
	'chat_id'=>$cid2,
	'text'=>"<b>❌ Tastiqlanmadi!</b>",
	'parse_mode'=>'html',
	]);
	bot('sendMessage',[
	'chat_id'=>$user_id,
	'text'=>"<b>🚫 So'rovingiz tastiqlanmadi, sababi soxta chek tashlagansiz!</b>",
	'parse_mode'=>'html',
	]);
	}
	
/*
@Stars_APIBot kodi!

Manba: @Org_Coder (Chopmanglar ancha mehnat ketgan)
Tarqatildi: @TexnoPHPuz kanalida
*/
?>
