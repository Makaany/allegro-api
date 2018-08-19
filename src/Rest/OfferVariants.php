<?php

namespace Ircykk\AllegroApi\Rest;

use Psr\Http\Message\ResponseInterface;
use Ircykk\AllegroApi\Exception\InvalidArgumentException;
use Http\Client\Exception;

class OfferVariants extends AbstractRestResource
{

    public function listingVariants(
        $userid = '',
        $offset = 0,
        $limit = 10,
        $query = ''
		) 
		
		{
        if (!$userid) {
            throw new InvalidArgumentException('user id must be provided');
        }
		
        return $this->get('/sale/offer-variants?'.http_build_query(
                [
                    'user.id' => $userid,
                    'offset' => $offset,
                    'limit' => $limit,
                    'query' => $query,
                ]
        ));
    }
}
