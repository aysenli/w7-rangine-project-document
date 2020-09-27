<?php

/**
 * WeEngine Document System
 *
 * (c) We7Team 2019 <https://www.w7.cc>
 *
 * This is not a free software
 * Using it under the license terms
 * visited https://www.w7.cc for more details
 */

namespace W7\App\Command\Install;

use W7\Console\Command\CommandAbstract;
use W7\Core\Exception\CommandException;
use W7\Core\Facades\Config;

class SyncDataCommand extends CommandAbstract
{
	private $userIds;

	protected function handle($options)
	{
		try {
			$get = [
				'host' => Config::get('install.database.host'),
				'username' => Config::get('install.database.username'),
				'password' => Config::get('install.database.password'),
				'database' => Config::get('install.database.database'),
			];

//			获取用户 (商城数据库配置)
			$userDataBase = [
				'host' => ienv('DATABASE_MEMBER_HOST'),
				'username' => ienv('DATABASE_MEMBER_USERNAME'),
				'password' => ienv('DATABASE_MEMBER_PASSWORD'),
				'database' => ienv('DATABASE_MEMBER_DATABASE'),
			];

//			要获取数据的所有表名称
			$tables = [
				'ims_wiki',
				'ims_wiki_list',
				'ims_wiki_view',
				'ims_members',
			];

//			定义生成的sql文件
			$file = RUNTIME_PATH . '/document.sql';
			if (file_exists($file)) {
				unlink($file);
			}

//			拓展检查
			$this->checkExtension();

//			生成sql文件
			$this->insertData($get, $userDataBase, $tables, $file);
		} catch (\Exception $e) {
			$this->output->error($e->getMessage());
		}
	}

	private function checkExtension()
	{
		$this->output->info('检查PHP扩展: ');
		$this->segmentation();

		$ext = 'mysqli';
		if (!extension_loaded($ext)) {
			throw new CommandException($ext . ' 扩展未安装');
		}

		if (is_writable(BASE_PATH) === false) {
			throw new CommandException('请检查' . BASE_PATH . '目录权限！');
		}

		if (is_writable(RUNTIME_PATH) === false) {
			throw new CommandException('请检查' . RUNTIME_PATH . '目录权限！');
		}

		$this->output->writeln('PHP扩展已检查完毕!');

		$this->segmentation();
	}

	private function insertData($get, $userDataBase, $tables, $file)
	{
		if (!$get || !$userDataBase || !$tables || !$file) {
			throw new CommandException('请检查数据配置！');
		}

		if ($get) {
			$this->checkDatabase($get);
		}

		if ($userDataBase) {
			$this->checkDatabase($userDataBase);
		}

		$sql = '';

		$dirChapters = [];
		$maxChapterId = 0;
		$handle = fopen($file, 'a');
		foreach ($tables as $key => $table) {
			$data = $this->getdata($table, $get, $userDataBase);
			if ($data) {
				if ($table == 'ims_wiki') {
					$i = 0;
					foreach ($data as $k => $v) {
						$this->userIds[$k] = $v['creator_id'];

						$sql .= 'INSERT INTO ims_document (id, name, description,creator_id,created_at,updated_at,is_public) VALUES( ';
						$sql .= " '".$v['id']."', '".$v['name']."', '".$v['description']."', '".$v['creator_id']."', '".$v['created_at']."','".$v['updated_at']."', '".$v['is_show']."' );".PHP_EOL;

						$sql .= 'INSERT INTO ims_document_permission (id, user_id, document_id, permission, created_at,updated_at) VALUES( ';
						$sql .= " '".$v['id']."', '".$v['creator_id']."', '".$v['id']."', 1,'".$v['created_at']."', '".$v['updated_at']."' );".PHP_EOL;

						$res = $this->setContent($i, count($data), $sql, $handle);
						if ($res) {
							$sql = '';
						}
						$i++;
					}
				} elseif ($table == 'ims_wiki_list') {
					$i = 0;
					$parentIds = array_column($data, 'parent_id');
					foreach ($data as $k => $v) {
						$isDir = 0;
						$maxChapterId = $v['id'] > $maxChapterId ? $v['id'] : $maxChapterId;
						if (in_array($v['id'], $parentIds)) {
							$isDir = 1;
							$dirChapters[$v['id']] = $v;
						}
						$sql .= 'INSERT INTO ims_document_chapter (id, parent_id, name,document_id,sort,levels,is_dir, created_at,updated_at) VALUES( ';
						$sql .= " '".$v['id']."', '".$v['parent_id']."', '".$v['name']."', '".$v['document_id']."', '".$v['sort']."', '".$v['levels']."', '". $isDir ."', '".$v['created_at']."', '".$v['updated_at']."' ); ".PHP_EOL;

						$res = $this->setContent($i, count($data), $sql, $handle);
						if ($res) {
							$sql = '';
						}
						$i++;
					}
				} elseif ($table == 'ims_wiki_view') {
					$i = 0;
					$chapterNum = count($data);
					foreach ($data as $k => $v) {
						//表示该章节是目录并且有内容，创建新的章节
						if (!empty($dirChapters[$v['chapter_id']])) {
							++$maxChapterId;
							++$chapterNum;
							$sql .= 'INSERT INTO ims_document_chapter (id, parent_id, name,document_id,sort,levels,is_dir, created_at,updated_at) VALUES( ';
							$sql .= " '".$maxChapterId."', '".$v['chapter_id']."', '".$dirChapters[$v['chapter_id']]['name']."', '".$dirChapters[$v['chapter_id']]['document_id']."', '".$dirChapters[$v['chapter_id']]['sort']."', '".$dirChapters[$v['chapter_id']]['levels']."', '". 0 ."', '".$dirChapters[$v['chapter_id']]['created_at']."', '".$dirChapters[$v['chapter_id']]['updated_at']."' ); ".PHP_EOL;
							$v['chapter_id'] = $maxChapterId;
							$i++;
							$res = $this->setContent($i, $chapterNum, $sql, $handle);
							if ($res) {
								$sql = '';
							}
						}

						$sql .= 'INSERT INTO ims_document_chapter_content (id, chapter_id, content,layout) VALUES( ';
						$content = htmlspecialchars_decode(html_entity_decode($v['content']));
						$content = str_replace('&#039;', "'", $content);
						$content = addslashes($content);
						$sql .= " '".$v['id']."', '".$v['chapter_id']."', '".$content."', '".$v['layout']."' ); ".PHP_EOL;
						$res = $this->setContent($i, $chapterNum, $sql, $handle);
						if ($res) {
							$sql = '';
						}

						$i++;
					}
				} elseif ($table == 'ims_members') {
					$i = 0;
					foreach ($data as $k => $v) {
						if ($v['username'] != 'admin') {
							$sql .= 'INSERT INTO ims_user (id, username, is_ban, created_at, updated_at) VALUES( ';
							$sql .= " '".$v['id']."', '".$v['username']."','".$v['is_ban']."',".$v['created_at'].",".$v['updated_at']."); ".PHP_EOL;

							$res = $this->setContent($i, count($data), $sql, $handle);
							if ($res) {
								$sql = '';
							}
						}
						$i++;
					}
				}
			}
		}

		fclose($handle);

		$this->output->success('success！ 生成的SQL文件在runtime目录下的document.sql');
	}

	private function getdata($table, $get, $userDataBase)
	{
		if ($table == 'ims_members') {
			$conn = new \mysqli($userDataBase['host'], $userDataBase['username'], $userDataBase['password']);
			if ($conn->connect_error) {
				throw new CommandException('连接失败' . $conn->connect_error);
			}
			$this->output->writeln($userDataBase['host'].'连接成功');
			mysqli_query($conn, 'set names utf8');
			mysqli_select_db($conn, $userDataBase['database']);
		} else {
			$conn = new \mysqli($get['host'], $get['username'], $get['password']);
			if ($conn->connect_error) {
				throw new CommandException('连接失败' . $conn->connect_error);
			}
			$this->output->writeln($get['host'].'连接成功');
			mysqli_query($conn, 'set names utf8');
			mysqli_select_db($conn, $get['database']);
		}

		//        获取数据
		$data = [];

		if ($table == 'ims_wiki') {
			$sql = "select * from $table ";
		} elseif ($table == 'ims_wiki_list') {
			$sql = "select * from $table ";
		} elseif ($table == 'ims_wiki_view') {
			$sql = "select id,listid,content from $table ";
		} elseif ($table == 'ims_members') {
			if ($this->userIds) {
				$this->userIds = rtrim(implode(',',array_unique($this->userIds)),',');
				$sql = "select uid,username,password,status,joindate from $table where uid in ($this->userIds) ";
			}else{
				throw new CommandException('获取不到用户ID');
			}
		}

		$retval = mysqli_query($conn, $sql);
		if (!$retval) {
			throw new CommandException('连接失败' . mysqli_error($conn));
		}
		while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
			$data[] = $row;
		}
		$retval->close();
		if ($data) {
			mysqli_close($conn);
			return $this->handleData($data, $table);
		}
		return false;
	}

	private function handleData($data, $table)
	{
		if (!$data) {
			return '数据为空';
		}

		$tmp_data = [];
		if ($table == 'ims_wiki') {
			foreach ($data as $k => $v) {
				$tmp_data[$k]['id'] = $v['id'];
				$tmp_data[$k]['name'] = $v['title'];
				$tmp_data[$k]['description'] = $v['description'];
				$tmp_data[$k]['creator_id'] = $v['uid'];
				$tmp_data[$k]['created_at'] = $v['createtime'] == 0 ? strtotime(time()) : $v['createtime'];
				$tmp_data[$k]['updated_at'] = $v['createtime'] == 0 ? strtotime(time()) : $v['createtime'];
				$tmp_data[$k]['is_show'] = $v['isread'] == 0 ? 2 : 1;
			}
		} elseif ($table == 'ims_wiki_list') {
			foreach ($data as $k => $v) {
				$tmp_data[$k]['id'] = $v['id'];
				$tmp_data[$k]['parent_id'] = $v['parentid'];
				$tmp_data[$k]['name'] = $v['name'];
				$tmp_data[$k]['document_id'] = $v['wikiid'];
				$tmp_data[$k]['sort'] = $v['displayorder'];
				$tmp_data[$k]['levels'] = 0;

				if (intval($v['lasttime']) <= 0 || !$v['lasttime'] || $v['lasttime'] == false) {
					$tmp_data[$k]['created_at'] = strtotime('now');
					$tmp_data[$k]['updated_at'] = strtotime('now');
				} else {
					$tmp_data[$k]['created_at'] = $v['lasttime'];
					$tmp_data[$k]['updated_at'] = $v['lasttime'];
				}
			}
		} elseif ($table == 'ims_wiki_view') {
			foreach ($data as $k => $v) {
				$tmp_data[$k]['id'] = $v['id'];
				$tmp_data[$k]['chapter_id'] = $v['listid'];
				$tmp_data[$k]['content'] = $v['content'];
				$tmp_data[$k]['layout'] = 1;
			}
		} elseif ($table == 'ims_members') {
			foreach ($data as $k => $v) {
				$tmp_data[$k]['id'] = $v['uid'];
				$tmp_data[$k]['username'] = $v['username'];
				$tmp_data[$k]['is_ban'] = $v['status'];
				$tmp_data[$k]['created_at'] = $v['joindate'];
				$tmp_data[$k]['updated_at'] = $v['joindate'];
			}
		}
		return $tmp_data;
	}

	private function setContent($i, $count, $sql, $handle)
	{
		if ($i%100 == 0) {
			fwrite($handle, $sql);
			return true;
		} elseif ($i == $count -1) {
			fwrite($handle, $sql);
			return true;
		}
	}

	private function checkDatabase($database)
	{
//		if (isset($database['host']) && $database['host']) {
//			$pat = "/^(((1?\d{1,2})|(2[0-4]\d)|(25[0-5]))\.){3}((1?\d{1,2})|(2[0-4]\d)|(25[0-5])):[0-9]{2,6}$/";
//			$pat2 = "/[\w][\w-]*\.(?:com\.cn|com|cn|co|net|org|gov|cc|biz|info)(\/|$)/isU";
//			if (!preg_match($pat, $database['host']) && !preg_match($pat2, $database['host'])) {
//				throw new CommandException('host填写错误');
//			}
//		}
		if (!isset($database['username']) || !$database['username']) {
			throw new CommandException('username不能为空');
		}
		if (!isset($database['password']) || !$database['password']) {
			throw new CommandException('password不能为空');
		}
		if (!isset($database['database']) || !$database['database']) {
			throw new CommandException('database不能为空');
		}
	}

	private function segmentation()
	{
		$this->output->writeln('');
	}
}
