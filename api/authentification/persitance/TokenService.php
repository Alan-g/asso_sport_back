<?php


class TokenService extends Database
{
    public function createToken($userName){
        $id = $this->insert("INSERT INTO token (uuid,token_uuid,end_date) VALUES ((SELECT uuid FROM user WHERE username = '$userName'), uuid(), ADDTIME(NOW(),'05:00:00'))");
        $result = $this->select("SELECT token_uuid,end_date FROM token where id = '$id' ");
        $obj = $result->fetch_object();
        return new Token($obj->token_uuid,$obj->end_date);
    }

    public function deleteToken($tokenUuid){
        $this->insert("DELETE FROM token WHERE token_uuid = '$tokenUuid'");
    }

    public function getToken($userName) {
        $result = $this->select("SELECT token_uuid,end_date FROM token where uuid = (SELECT uuid FROM user WHERE username = '$userName') ");
        if (!$result) {
            return null;
        }
        $obj = $result->fetch_object();
        return new Token($obj->token_uuid,$obj->end_date);
    }

    public function getTokenByuuid($tokenuuid) {
        $result = $this->select("SELECT token_uuid,end_date FROM token where token_uuid = '$tokenuuid' ");
        if (!$result) {
            return null;
        }
        $obj = $result->fetch_object();
        return new Token($obj->token_uuid,$obj->end_date);
    }
}