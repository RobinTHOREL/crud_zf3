<?php

declare(strict_types=1);

namespace Meetup\Controller;

use Meetup\Repository\MeetupRepository;
use Meetup\Form\MeetupForm;
use Zend\Http\PhpEnvironment\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

final class IndexController extends AbstractActionController
{
    /**
     * @var MeetupRepository
     */
    private $MeetupRepository;

    /**
     * @var MeetupForm
     */
    private $MeetupForm;

    public function __construct(MeetupRepository $MeetupRepository, MeetupForm $MeetupForm)
    {
        $this->MeetupRepository = $MeetupRepository;
        $this->MeetupForm = $MeetupForm;
    }

    public function indexAction()
    {
        return new ViewModel([
            'Meetups' => $this->MeetupRepository->findAll(),
        ]);
    }

    public function addAction()
    {
        $form = $this->MeetupForm;

        /* @var $request Request */
        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                if(new \DateTimeImmutable($form->getData()['startDate'])>= date('now')
                    && new \DateTimeImmutable($form->getData()['startDate']) < new \DateTimeImmutable($form->getData()['endDate'])) {
                    $this->MeetupRepository->save($form->getData());
                    return $this->redirect()->toRoute('meetups');
                }
            }
        }

        $form->prepare();

        return new ViewModel([
            'form' => $form,
        ]);
    }

    public function deleteAction()
    {
        /** @var Request $request */
        $request = $this->getRequest();

        /** @var string $id */
        $id = (string)$request->getPost('id');

        if (empty($id)) {
            throw new \Exception('Une erreur est survenue');
        }

        $this->MeetupRepository->delete($id);

        return $this->redirect()->toRoute('meetups');
    }

    public function editAction()
    {
        $form = $this->MeetupForm;

        $id = $this->params()->fromRoute('id');

        $meetup = $this->MeetupRepository->find($id);

        $form->bind($meetup);

        /* @var $request Request */
        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->MeetupRepository->save($form->getData());
                return $this->redirect()->toRoute('meetups');
            }

        }

        $form->prepare();

        return new ViewModel([
            'form' => $form,
            'meetup' => $meetup,
        ]);
    }
}
