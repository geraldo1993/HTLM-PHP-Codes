USE chinese_zodiac;

CREATE TABLE zodiac_signs
(
    sign            varchar(32)    NOT NULL UNIQUE,
    president       varchar(128)   NOT NULL UNIQUE
);

INSERT INTO zodiac_signs(sign)
VALUES 
("Rat", "George Washington"),
("Ox", "Barack Obama"),
("Tiger", "Dwight Eisenhower"),
("Rabbit", "John Adams"),
("Dragon", "Abraham Lincoln"),
("Snake", "John Kennedy"),
("Horse", "Theodore Roosevelt"),
("Goat", "James Madison"),
("Monkey", "Harry Truman"),
("Rooster", "Grover Cleveland"),
("Dog", "George Walker Bush"),
("Pig", "Ronald Reagan");

CREATE TABLE zodiac_profiles 
(
    profile_id      integer         NOT NULL AUTO_INCREMENT PRIMARY KEY,
    first_name      varchar(256)    NOT NULL,
    last_name       varchar(256)    NOT NULL,
    user_name       varchar(256)    NOT NULL UNIQUE,
    user_password   varchar(256)    NOT NULL,
    user_email      varchar(256)    NOT NULL,
    user_profile    varchar(1024)   NULL,
    user_sign       varchar(256)    NULL,
    CONSTRAINT FOREIGN KEY fk_zodiac_profiles_zodiac_signs
    (user_sign) REFERENCES zodiac_signs(sign)
    ON DELETE SET NULL
    ON UPDATE SET NULL
);

CREATE TABLE zodiac_feedback
(
    message_date        date,
    message_time        time,
    message_timestamp   timestamp       DEFAULT current_timestamp,
    sender              varchar(40),
    message             varchar(255),
    public_message      enum('Y', 'N')
);

INSERT INTO zodiac_feedback(message_date, message_time, 
    sender, message, public_message)
VALUES
(date(current_timestamp), time(current_timestamp), 'Darth Vader', 
    'You should have used Python, PHP causes permanent brain damage.', 'Y'),
(date(current_timestamp), time(current_timestamp), 'Master Yoda', 
    'Powerful you have become, the dark side I sense in you.', 'Y'),
(date(current_timestamp), time(current_timestamp), 'Spock', 
    'Live long and prosper.', 'Y'),
(date(current_timestamp), time(current_timestamp), 'Amanda Greystone', 
    'All this has happened before, and all this will happen again.', 'Y');    

CREATE TABLE zodiac_years
(
    sign            varchar(32)    NOT NULL UNIQUE,
    year            smallint       NOT NULL UNIQUE,
    CONSTRAINT FOREIGN KEY fk_zodiac_years_zodiac_signs
    (sign) REFERENCES zodiac_signs(sign)
);

CREATE TABLE random_proverb
(
    proverb_id      integer        NOT NULL AUTO_INCREMENT PRIMARY KEY,
    proverb_text    varchar(1000)  NOT NULL,
    proverb_count   integer        NOT NULL DEFAULT 0
)
CHARACTER SET utf8 COLLATE utf8_bin
;

INSERT INTO random_proverb(proverb_text)
VALUES
("书是随时携带的花园 shū shì suí shí xié dài de huā yuán - A book is like a garden carried in the pocket."),
("万事开头难 wàn shì kāi tóu nán - All things are difficult before they are easy."),
("活到老，学到老 huó dào lǎo, xué dào lǎo - A man is never too old to learn."),
("身正不怕影子斜 shēn zhèng bú pà yǐng zi xié - A straight foot is not afraid of a crooked shoe."),
("爱屋及乌 ài wū jí wū - Love me ,love my dog."),
("好书如挚友 hǎo shū rú zhì yǒu – A good book is a good friend."),
("一寸光阴一寸金, 寸金难买寸光阴 yí cùn guāng yīn yí cùn jīn, cùn jīn nán mǎi cùn guāng yīn - Time is money, and it is difficult for one to use money to get time."),
("机不可失，时不再来 jī bù kě shī, shí bú zài lái - Opportunity knocks at the door only once."),
("一言既出，驷马难追 yì yán jì chū, sì mǎ nán zhuī - A word spoken can never be taken back."),
("好记性不如烂笔头 hǎo jì xìng bù rú làn bǐ tóu - The palest ink is better than the best memory."),
("近水知鱼性, 近山识鸟音jìn shuǐ zhī yú xìng, jìn shān shí niǎo yīn - Near to rivers, we recognize fish, near to mountains, we recognize the songs of birds. It is very important to make on-the-spot investigations."),
("愿得一人心，白首不相离 yuàn dé yī rén xīn, bái shǒu bù xiāng lí - Catch one’s heart, never be apart."),
("人心齐，泰山移 rén xīn qí, tài shān yí - When people work with one mind, they can even remove Mount Taishan."),
("明人不用细说，响鼓不用重捶 míng rén bú yòng xì shuō, xiǎng gǔ bú yòng zhòng chuí - People of good sense or expertise need only a hint to understand any matter."),
("花有重开日，人无再少年huā yǒu chóng kāi rì, rén wú zài shào nián, - Flowers may bloom again, but a person never has the chance to be young again. So don't waste your time."),
("顾左右而言他 gù zuǒ yòu ér yán tā - Turning aside and changing the subject."),
("几家欢喜几家愁 jǐ jiā huān xǐ jǐ jiā chóu - Some are happy, some have worries. Or one man’s disaster is another man’s delight."),
("人无完人，金无足赤 rén wú wán rén, jīn wú zú chì - It is as impossible to find a perfect man as it is to find 100 percent pure gold."),
("有借有还，再借不难 yǒu jiè yǒu hái, zài jiè bù nán - Timely return of a loan makes it easier to borrow a second time."),
("失败是成功之母 / Shībài shì chénggōng zhī mǔ / Failure is mother of success."),
("人过留名，雁过留声 rén guò liú míng, yàn guò liú shēng -A person leaves a reputation, bad or good, behind wherever he works or stays.")
;