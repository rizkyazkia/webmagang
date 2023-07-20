DELIMITER ;
CREATE TABLE logistic_account(
    ID_User INT PRIMARY KEY AUTO_INCREMENT,
    Email VARCHAR(255) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    CreatedAt DATETIME DEFAULT CURRENT_TIME
);

INSERT INTO logistic_account VALUES("","admin@logistik.com","admin123",CURRENT_DATE);

CREATE TABLE logistic_document (
    ID_LogDoc INT AUTO_INCREMENT PRIMARY KEY,
    ID_Document VARCHAR(255),
    ID_User INT,
    File_Document TEXT,
    FOREIGN KEY (ID_User) REFERENCES logistic_account(ID_User) ON UPDATE CASCADE ON DELETE CASCADE
);
CREATE TABLE logistic_user_data(
    ID_UserData INT PRIMARY KEY AUTO_INCREMENT,
    Nama_Penerima VARCHAR(255) NOT NULL,
    Nama_Pengirim VARCHAR(255) NOT NULL,
    InstitusiPengirim VARCHAR(255) NOT NULL,
    InstitusiPenerima VARCHAR(255) NOT NULL,
    Sign_File_Pengirim TEXT,
    Sign_File_Penerima TEXT,
    Tanggal_BAST DATE,
    Nama_Pengawas VARCHAR(255),
    InstitusiPengawas VARCHAR(255)
);
CREATE TABLE logistic_doc_user (
    ID_DocUser INT PRIMARY KEY AUTO_INCREMENT,
    ID_LogDoc INT,
    ID_UserData INT,
    FOREIGN KEY (ID_LogDoc) REFERENCES logistic_document(ID_LogDoc) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (ID_UserData) REFERENCES logistic_user_data(ID_UserData) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE logistic_inventory (
    ID_Inv INT PRIMARY KEY AUTO_INCREMENT,
    ID_LogDoc INT,
    Nama_Barang VARCHAR(255) NOT NULL,
    Volume_Barang CHAR(3) NOT NULL,
    Satuan_Barang VARCHAR(50) NOT NULL,
    Ket_Barang TEXT NOT NULL,
    FOREIGN KEY (ID_LogDoc) REFERENCES logistic_document(ID_LogDoc) ON UPDATE CASCADE ON DELETE CASCADE
);

-- PHASE 1 (User Data)
CREATE OR REPLACE PROCEDURE SetUserDataPengirim(
    IN Nama_Pengirim TEXT,
    IN InstitusiPengirim TEXT,
    IN Sign_File_Pengirim TEXT
)
BEGIN
    DECLARE IDUserData INT;
    DECLARE IDDocUser INT;
    DECLARE ID_LogDocs INT;
    SELECT ID_UserData FROM logistic_user_data ORDER BY `ID_UserData` DESC LIMIT 1 INTO IDUserData;
    UPDATE logistic_user_data SET Nama_Pengirim = Nama_Pengirim, InstitusiPengirim = InstitusiPengirim, Sign_File_Pengirim = Sign_File_Pengirim WHERE ID_UserData = IDUserData;
    SELECT `ID_LogDoc` FROM logistic_document ORDER BY `ID_LogDoc` DESC LIMIT 1 INTO ID_LogDocs;
    SELECT ID_DocUser FROM logistic_doc_user ORDER BY ID_DocUser DESC LIMIT 1 INTO IDDocUser;
    UPDATE logistic_doc_user SET ID_LogDoc = ID_LogDocs, ID_UserData = IDUserData WHERE ID_DocUser = IDDocUser;
END;

CREATE OR REPLACE PROCEDURE SetUserDataPenerima(
    IN Nama_Penerima TEXT,
    IN InstitusiPenerima TEXT,
    IN Sign_File_Penerima TEXT
)
BEGIN
    DECLARE IDUserData INT;
    SELECT ID_UserData FROM logistic_user_data ORDER BY `ID_UserData` DESC LIMIT 1 INTO IDUserData;
    UPDATE logistic_user_data SET 
    `Nama_Penerima` = Nama_Penerima, 
    `InstitusiPenerima` = InstitusiPenerima,
    `Sign_File_Penerima` = Sign_File_Penerima WHERE `ID_UserData` = IDUserData;
END;

CREATE OR REPLACE PROCEDURE SetUserDataPengirim2(
    IN Nama_Pengirim TEXT,
    IN InstitusiPengirim TEXT,
    IN Sign_File_Pengirim TEXT
)
BEGIN
    DECLARE IDUserData INT;
    DECLARE PrevTanggal TEXT;
    DECLARE ID_LogDocs INT;
    SELECT `Tanggal_BAST` FROM logistic_user_data ORDER BY `Tanggal_BAST` DESC LIMIT 1 INTO PrevTanggal;
    INSERT INTO logistic_user_data VALUES("", "", `Nama_Pengirim`, `InstitusiPengirim`, "", `Sign_File_Pengirim`, "", PrevTanggal,"","");
    SELECT ID_UserData FROM logistic_user_data ORDER BY `ID_UserData` DESC LIMIT 1 INTO IDUserData;
    SELECT `ID_LogDoc` FROM logistic_document ORDER BY `ID_LogDoc` DESC LIMIT 1 INTO ID_LogDocs;
    INSERT INTO logistic_doc_user VALUES("",ID_LogDocs, IDUserData);
END;

CREATE OR REPLACE PROCEDURE insertDataBarang(
    IN Nama_Barang VARCHAR(255),
    IN Volume_Barang VARCHAR(255),
    IN Satuan_Barang VARCHAR(255),
    IN Ket_Barang TEXT
)
BEGIN
    DECLARE IDDoc TEXT;
    SELECT `ID_LogDoc` FROM logistic_document ORDER BY `ID_LogDOc` DESC LIMIT 1 INTO IDDoc;
    INSERT INTO logistic_inventory VALUES ("",IDDoc, `Nama_Barang`,`Volume_Barang`,`Satuan_Barang`, `Ket_Barang`);
END;

CREATE OR REPLACE FUNCTION Document_IDShow() RETURNS VARCHAR(255) DETERMINISTIC
BEGIN
    DECLARE Document_GETID VARCHAR(255);
    SELECT `ID_LogDoc` FROM logistic_document ORDER BY `ID_LogDoc` DESC LIMIT 1 INTO Document_GETID;
    RETURN (Document_GETID);
END;
CREATE OR REPLACE PROCEDURE DeleteData(
    IN IDDocument VARCHAR(225)
)
BEGIN
    DECLARE finished INT DEFAULT 0;
    DECLARE UserAddress INT DEFAULT "";
    DECLARE curData CURSOR FOR SELECT ID_UserData FROM logistic_user_data JOIN logistic_doc_user USING(`ID_UserData`) WHERE `ID_LogDoc` = IDDocument;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET finished = 1;

    OPEN curData;
    getIDUser : LOOP
        FETCH NEXT FROM curData INTO UserAddress;
        IF finished = 1 THEN
            LEAVE getIDUser;
        END IF;
        DELETE FROM logistic_user_data WHERE ID_UserData = UserAddress;
    END LOOP getIDUser;
    CLOSE curData;
    DELETE FROM logistic_document WHERE ID_LogDoc = IDDocument;
END;

DROP FUNCTION IF EXISTS `ValidateLogin`;
DELIMITER //
CREATE FUNCTION ValidateLogin( emailinput VARCHAR(255), passwordinput VARCHAR(255))
    RETURNS VARCHAR(10) DETERMINISTIC
    BEGIN
        DECLARE status INT(1);
        DECLARE status2 VARCHAR(10);
        SELECT COUNT(`ID_User`) FROM logistic_account WHERE `Email` = emailinput AND Password = passwordinput INTO status;
        IF status < 1 THEN
            SET status2 = "False";
        ELSE
            SET status2 = "True";
        END IF;
        RETURN status2;
    END//
DELIMITER ;

CREATE OR REPLACE PROCEDURE InsertNewDoc(
    IN ID_User VARCHAR(5),
    IN ID_Document TEXT,
    IN Tanggal_Bast TEXT
)
BEGIN
    DECLARE ID_LogDoc INT;
    DECLARE ID_UserData INT;
    INSERT INTO logistic_user_data VALUES("","","","","","","", Tanggal_Bast, "","");
    INSERT INTO logistic_document VALUES("",ID_Document,ID_User,"");
    SELECT `ID_UserData` FROM logistic_user_data ORDER BY `ID_UserData` DESC LIMIT 1 INTO ID_UserData;
    SELECT `ID_LogDoc` FROM logistic_document ORDER BY `ID_LogDoc` DESC LIMIT 1 INTO ID_LogDoc;
    INSERT INTO logistic_doc_user VALUES("", ID_LogDoc, ID_UserData);
END;