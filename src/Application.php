<?php

namespace App;

use App\Contracts\RequestContract;

class Application
{
    private EmailClient $emailClient;
    protected array $fields = [
        'sendername',
        'senderemail',
        'eventtime',
        'eventname',
        'eventdescription',
        'guestname',
        'guestemail'
    ];

    public function __construct(protected RequestContract $request)
    {
        $this->emailClient = new EmailClient();
    }

    public static function run(RequestContract $request): ?string
    {
        $app = new static($request);

        return $app->process();
    }

    public function process(): ?string
    {
        $this->throwIfNotPostRequest();

        $data = $this->request->all($this->fields, true);
        $uuid = md5($data['eventname'].time());
        $ics = $this->getFilledICS([
            'UUID' => $uuid,
            'CURRENT_TIME' => datetime_to_cal(time()),
            'SENDER_NAME' => $data['sendername'],
            'SENDER_EMAIL' => $data['senderemail'],
            'EVENT_TIME_START' => datetime_to_cal($data['eventtime']),
            'EVENT_TIME_END' => datetime_to_cal($data['eventtime']),
            'EVENT_NAME' => $data['eventname'],
            'EVENT_DESCRIPTION' => $data['eventdescription']
        ]);

        $isSent = $this->emailClient->sendEmail(
            $data['senderemail'],
            $data['sendername'],
            $data['guestemail'],
            $data['guestname'],
            'New event: '.$data['eventname'],
            $data['eventdescription'],
            $this->saveFile($uuid, $ics)
        );

        return $this->prepareResponse($isSent);
    }

    private function prepareResponse(bool $isSent): ?string
    {
        if ($_ENV['APP_ENV'] === 'testing') {
            return null;
        }

        return (new Response())
            ->setData(["success" => $isSent])
            ->setStatus($isSent ? 200 : 500)
            ->render();
    }

    private function saveFile(string $uuid, string $content): string
    {
        $filepath = $this->prepareFilepath('storage').'/'.$uuid.'.ics';
        if (file_put_contents($filepath, $content) === false) {
            throw new \Exception('ICS File not saved');
        }

        return $filepath;
    }

    private function prepareFilepath(string $relativeFilepath): string
    {
        return realpath(__DIR__.'/../'.$relativeFilepath);
    }

    private function getFilledICS(array $map): string
    {
        $ics = file_get_contents( $this->prepareFilepath('templates/ics.template'));

        foreach ($map as $key => $value) {
            $ics = str_replace('{'.$key.'}', $value, $ics);
        }

        return $ics;
    }

    private function throwIfNotPostRequest()
    {
        if (!$this->request->isPost()) {
            header($_SERVER["SERVER_PROTOCOL"]." 405 Method Not Allowed", true, 405);
            throw new \Exception('Method Not Allowed');
        }
    }
}
