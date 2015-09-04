<?php
session_start();
require "config.inc.php";

function errMsg($errmsg, $to) {
	$_SESSION["errmsg"] = $errmsg;
	header("Location: $to");
	die();
}

function infoMsg($msg, $to) {
	$_SESSION["infomsg"] = $msg;
	header("Location: $to");
	die();
}

function getAllNumbers() {
    $numbers = array();
    $d = dir(HYLAFAX_ROOT . "etc/");
    while (false !== ($entry = $d->read())) {
        if(preg_match("/^config\\.tty(x[0-9]+)/", $entry, $matches)) {
            $output = "";
            $modem = "tty" . $matches[1];
            $faxnumber = exec("cat ".HYLAFAX_ROOT."etc/config.$modem | grep FAXNumber | awk -F' ' '{ print $2 }'", $output);
            $localidentifier = exec("cat ".HYLAFAX_ROOT."etc/config.$modem | grep LocalIdentifier | awk -F' ' '{ print $2 }'", $output);
            $numbers[$modem] = $localidentifier;
        }
    }
    return $numbers;
}

function getDoneq($inqueue=false) {
	$ret = array();

    $folder = $inqueue ? "sendq/" : "doneq/";

	$d = dir(HYLAFAX_ROOT . $folder);
	while (false !== ($entry = $d->read())) {
		if(preg_match("/^q[0-9]+$/", $entry)) {
			$rows = explode("\n", file_get_contents(HYLAFAX_ROOT . $folder . $entry));
			$infos = array();
			foreach($rows as $r) {
                if(trim($r) == "") continue;
				list($k, $v) = explode(":", $r, 2);
				if(HYLAFAX_REPLACEZERO && ($k == "number" || $k == "external")) {
					$v = preg_replace("/^0/", "", $v);
				}
				$infos[$k] = $v;

				if($k == "state") {
					switch(intval($v)) {
						case 1:
							$infos["state_string"] = "sospeso";
							break;
						case 2:
							$infos["state_string"] = "in coda per l'invio";
							break;
						case 3:
							$infos["state_string"] = "in attesa";
							break;
						case 4:
							$infos["state_string"] = "bloccato";
							break;
						case 5:
							$infos["state_string"] = "pronto per l'invio";
							break;
						case 6:
							$infos["state_string"] = "invio in corso";
							break;
						case 7:
							$infos["state_string"] = "invio completato";
							break;
						case 8:
							$infos["state_string"] = "invio fallito";
							break;
					}
				}
			}
			$ret[$infos["jobid"]] = $infos;
		}
	}
	krsort($ret);
	return $ret;
}

function getRecvq() {
	$ret = array();
	$d = dir(HYLAFAX_ROOT . "recvq/");
	while (false !== ($entry = $d->read())) {
		if($entry == "seqf") continue;

		$fname = HYLAFAX_ROOT . "recvq/$entry";
		$infos = `/usr/sbin/faxinfo -c "," $fname`;
        if(preg_match("/corrupted/", $infos)) continue;
		list($fname, $sender, $pages, $quality, $pagetype, $received, $ttr, $sr, $df, $ec) = explode(",", $infos);

		$id = intval(preg_replace("/^fax([0-9]+)\\.tif$/", "\\1", basename($fname)));

		if($sender == "" || $sender == "<UNSPECIFIED>") {
			$sender = "Anonimo";
		}

        if(HYLAFAX_REPLACEZERO) {
            $sender = preg_replace("/^0/", "", $sender);
        }

		$ret[$id] = array(
			"id" => $id,
			"sender" => $sender,
			"pages" => $pages,
			"quality" => $quality,
			"pagetype" => $pagetype,
			"received" => $received,
			"ttr" => $ttr,
			"sr" => $sr,
			"df " => $df,
			"ec" => $ec
		);
	}
	krsort($ret);
	return $ret;
}
