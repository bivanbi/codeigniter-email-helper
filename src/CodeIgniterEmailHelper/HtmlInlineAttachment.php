<?php


namespace KignOrg\CodeIgniterEmailHelper;


use KignOrg\CodeIgniterEmailHelper\Exceptions\EmailPreparationException;

class HtmlInlineAttachment
{
    const CID_ATTACHMENT_MATCH_PATTERN = '/%%cid:([^%]+)%%/';
    const CID_ATTACHMENT_REPLACE_PATTERN = 'cid:%%CID%%';
    const CID_PATTERN = '%%CID%%';

    private CodeIgniterEmailAdapter $emailAdapter;


    public function __construct(CodeIgniterEmailAdapter $email)
    {
        $this->emailAdapter = $email;
    }


    /**
     * @param string $html
     * @return string|null
     * @throws EmailPreparationException
     */
    public function parseHtmlAndAttachFiles(string $html): ?string
    {
        preg_match_all(self::CID_ATTACHMENT_MATCH_PATTERN, $html, $matches,PREG_SET_ORDER);

        foreach ($matches as $set) {
            $matchString = $set[0];
            $filePath = $set[1];

            $cid = $this->emailAdapter->attachInlineFile($filePath);
            $cidString = str_replace(self::CID_PATTERN, $cid, self::CID_ATTACHMENT_REPLACE_PATTERN);
            $html = str_replace($matchString, $cidString, $html);
        }

        return $html;
    }
}
