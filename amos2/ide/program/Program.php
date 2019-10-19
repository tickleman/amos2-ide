<?php
namespace Amos2\Ide;

use ITRocks\Framework\Dao;
use ITRocks\Framework\Traits\Duplicate_Discriminate_By_Counter;
use ITRocks\Framework\Traits\Has_Name;
use ITRocks\Framework\Traits\Has_Name_Duplicate;
use ITRocks\Framework\User;

/**
 * @before_write setNewProgramAuthor
 * @business
 * @display_order name, author, code
 * @feature
 * @list name, author
 */
class Program
{
	use Duplicate_Discriminate_By_Counter;
	use Has_Name_Duplicate;
	use Has_Name;

	//--------------------------------------------------------------------------------------- $author
	/**
	 * @default User::current
	 * @link Object
	 * @mandatory
	 * @user invisible_edit
	 * @var User
	 */
	public $author;

	//----------------------------------------------------------------------------------------- $code
	/**
	 * @max_length 10000000
	 * @multiline
	 * @var string
	 */
	public $code;

	//--------------------------------------------------------------------------------------- dirName
	/**
	 * A directory name that identifies the program (author and project name)
	 *
	 * @example tickleman/helloworld
	 * @param $separator string
	 * @return string
	 */
	public function dirName($separator = SL)
	{
		return strUriElement($this->author->login) . $separator . strUriElement($this->name);
	}

	//--------------------------------------------------------------------------- setNewProgramAuthor
	public function setNewProgramAuthor()
	{
		if (!Dao::getObjectIdentifier($this)) {
			$this->author = User::current();
		}
	}

}
