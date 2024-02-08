<?php

namespace App\DAO;

use App\DTO\API\CardContactDTO;
use App\DTO\API\CardContactsDTO;
use App\Enums\Status;
use App\Models\CardContact;

class CardContactDAO
{
    public function create(CardContactDTO $dto): CardContact
    {
        $cardContact = new CardContact();
        $cardContact->fill($dto->toArrayPrefixed(CardContact::PREFIX));
        $cardContact->save();

        return $cardContact;
    }

    public function createMultiple(CardContactsDTO $dto): array
    {
        $cardContacts = [];
        foreach ($dto->contacts as $contact) {
            $cardContact = new CardContact();
            $cardContact->fill($contact->toArrayPrefixed(CardContact::PREFIX));
            $cardContact->save();
            $cardContacts[] = $cardContact;
        }
        return $cardContacts;
    }

    public function update(CardContactDTO $dto, CardContact $cardContact): CardContact
    {
        $cardContact->fill($dto->toArrayPrefixed(CardContact::PREFIX))->getDirty();
        $cardContact->save();

        return $cardContact;
    }

    public function softDelete(CardContact $cardContact)
    {
        $cardContact->cco_status = Status::DELETED;
        $cardContact->save();
    }
}
